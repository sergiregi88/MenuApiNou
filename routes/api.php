<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Auth\AuthController;
use App\Http\Controllers\User\Auth\NewPasswordController;
use App\Http\Controllers\User\Auth\EmailVerificationController;
use App\Http\Controllers\User\UserDetailsAndStatsController;
use App\Http\Controllers\User\Auth\VerifyNewEmailController;
use App\Http\Controllers\NoUser\GameSlotResumeController;
use App\Http\Controllers\NoUser\GameDataController;
use App\Http\Controllers\NoUser\GameSlotController;
use App\Models\GameSlot\GameSlotResumeData;
use Illuminate\Support\Facades\Config;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix("v1")->group(function(){
    Route::get("test",function(){
        return Config::get('auth.verification.expire',99);
    });
    Route::prefix("nouser")->group(function(){

        Route::get("gameData",[GameDataController::class,"CreateGetUniqueGameData"]);
        Route::put("gameData",[GameDataController::class,"UpdateUniqueGameData"]);
        //Route::get("getGameDataSlotsResume",[GameDataController::class,'GetGameDataSlotsResume']);
        Route::get("gameSlotData/{id}",[GameSlotController::class,'GetGameSlotData']);
        Route::put("gameSlotData/{id}",[GameSlotController::class,'PutGameSlotData']);

        Route::post("GameSlotResume",[GameSlotResumeController::class,"CreateGameSlotResume"]);
        Route::get("GameSlotResume",[GameSlotResumeController::class,"GetAllGameSlotsResumes"]);
    });
  
    Route::prefix("user")->group(function(){
        Route::post("register",[AuthController::class,'register']);
        Route::post("login",[AuthController::class,'login']);
        Route::post("forgot-password/{IsUsingUnity}",[NewPasswordController::class,'forgotPassword']);
        Route::post("reset-password",[NewPasswordController::class,'reset']);
        Route::get("reset-password/{token}",[NewPasswordController::class,'resetToken']);
        Route::post("logout",[AuthController::class,'logout']);
        Route::get('verify-email-login/{id}/{hash}', [EmailVerificationController::class, 'verifyUserLogin'])->name('verification.verify')->middleware("signed");
        Route::get('verify-email-login/{id}/{hash}/{unityReq}', [EmailVerificationController::class, 'verifyUserLogin'])->name('verification.verifyUserLogin')->middleware("signed");
        Route::get('pendingEmail/verify/{token}', [VerifyNewEmailController::class, 'verify'])->name('pendingEmail.verify');
        Route::get('pendingEmail-unity/verify/{token}', [VerifyNewEmailController::class, 'verifyUnity'])
    ->middleware(['signed'])->name('pendingEmail.verifyLogin');
        Route::group(['middleware'=>["auth:sanctum"]],function(){
            Route::post("verification-notification",[EmailVerificationController::class,'sendEmailVerification']);
            Route::post('resend-email-verification',[EmailVerificationController::class,'resendEmailVerification']);
            Route::post("resend-update-user-email-unity",[UserDetailsAndStatsController::class,'ResendUpdateUserEmailUnity']);
            Route::group(['middleware'=>["verified"]],function(){
                Route::get('user-details-and-stats',[UserDetailsAndStatsController::class,'GetData']);
                Route::put("update-user-details/1",[UserDetailsAndStatsController::class,'UpdateUserDetails']);
                Route::put("update-user-stats/1",[UserDetailsAndStatsController::class,'UpdateUserStats']);
                Route::put("update-user-data/1",[UserDetailsAndStatsController::class,'UpdateUserData']);
                Route::post("update-user-email",[UserDetailsAndStatsController::class,'UpdateUserEmail']);
                Route::post("update-user-email-unity",[UserDetailsAndStatsController::class,'UpdateUserEmailUnity']);
                
                Route::post("update-user-password",[UserDetailsAndStatsController::class,'UpdateUserPassword']);
            });
        });
    });
        
});

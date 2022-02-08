<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Auth\AuthController;
use App\Http\Controllers\User\Auth\NewPasswordController;
use App\Http\Controllers\User\Auth\EmailVerificationController;
use App\Http\Requests\EmailVerificationRequestApi;

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

    Route::prefix("nouser")->group(function(){
    
    });
  
    Route::prefix("user")->group(function(){
        Route::post("register",[AuthController::class,'register']);
        Route::post("login",[AuthController::class,'login']);
        Route::post("forgot-password/{IsUsingUnity}",[NewPasswordController::class,'forgotPassword']);
        Route::post("reset-password",[NewPasswordController::class,'reset']);
        Route::get("reset-password/{token}",[NewPasswordController::class,'resetToken']);
        
        Route::get('verify-email-login/{id}/{hash}', [EmailVerificationController::class, 'verifyUserLogin'])->name('verification.verify');//->middleware("signed");
        Route::get('verify-email-login/{id}/{hash}/{unityReq}', [EmailVerificationController::class, 'verifyUserLogin'])->name('verification.verifyUserLogin');///->middleware("signed");
        
        Route::group(['middleware'=>["auth:sanctum",]],function(){
            Route::post("verification-notification/{IsUnityReq}",[EmailVerificationController::class,'sendEmailVerification']);
          ///  Route::get('verify-email-login/{id},/{hash}', [EmailVerificationController::class, 'verifyUserLogin'])->name('verification.verify')->middleware('jsonMiddleware');
            Route::post("register2",[AuthController::class,'register']);
            Route::post('resend-email-verification',[EmailVerificationController::class,'resendEmailVerification']);
        });
    });
        
});

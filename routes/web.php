<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Auth\EmailVerificationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("reset-password",[NewPasswordController::class,'resetGet']);
Route::get("verifyNewEmailCorrect",function(){
    
});

//Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verifyUserWeb'])->name('verification.verifyweb');

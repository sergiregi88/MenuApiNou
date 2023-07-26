<?php

namespace App\Http\Controllers\User\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Support\Facades\Validator;

class NewPasswordController extends ApiController
{
    public function forgotPassword(Request $request, $IsUsingUnity)
    {
        
        $validator = Validator::make($request->all(), [
            "email" => "required|string|email"
        ]);
        
        if ($validator->fails()) {
            
            return $this->respondValidationErrors($validator);
        }
        
        if ($IsUsingUnity == "0") {
        
            $status = Password::sendResetLink($request->only("email"));

            if ($status == Password::INVALID_USER) {
                return $this->respondUnprocessableEntity("We not have this email registered.");
            }

            if ($status == Password::RESET_THROTTLED) {
                return  $this->respondUnprocessableEntity(" throttled reset");
            }

            if ($status == Password::RESET_LINK_SENT) {
                return $this->respondSuccessMessage($status);
            }
            
            // si jo faig mes endavnt un client web amb login i registtre i tot 
            // si vull fer reset sende enviar correu 
        } else if ($IsUsingUnity == "1") {
        
            $data=null;
            $res = Password::sendResetLink($request->only("email"), function ($user, $token) use (& $data) {
                $data['email'] = $user->email;
                $data['token'] = $token;
                $user->sendPasswordResetNotification($token);
                return $data;
            });
        
            if ($res == Password::INVALID_USER) {
                return $this->respondUnprocessableEntity("We not have this email registered.");
            }

            if ($res== Password::RESET_THROTTLED) {
                return  $this->respondUnprocessableEntity("Too much requests wait a minute...");
            }

            if (is_array($res)) {
    
                return $this->respondSuccessDataMessage($res," Initinated Reset Paswsword");
            }
            
        } else {
            return  $this->respondUnprocessableEntity("Wrong Parameter");
        }
    }
  // es accepatble q una app unity faci un forgotpasssword i envi a reset directe ?
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "token" => "required",
            "email" => "required|string|email",
            "password" => ["required", "confirmed"],
        ]);
        if ($validator->fails()) {
            return $this->respondValidationErrors($validator);
        }
        $status = Password::reset(
            $request->only("email", "password", "password_confirmation", "token"),
            function ($user) use ($request) {
                $user->forceFill([
                    "password" => Hash::make($request->password),
                    "remember_token" => Str::random(60)
                ])->save();
                event(new PasswordReset($user));
            }
        );
        if ($status == Password::PASSWORD_RESET) {
            return $this->respondSuccessMessage("Password chaged correctly");
        }
        if ($status == Password::INVALID_USER) {
            return $this->respondUnprocessableEntity("We don't have this user registered.");
        }
        if ($status == Password::INVALID_TOKEN) {

            return  $this->respondUnprocessableEntity("This token is not valid.");
        }


        return   $this->respondInternalError();
    }
    public function resetToken(Request $request,$token){
      
        return view("reset-password",["token"=>$token,]);
    }
}

<?php

namespace App\Http\Controllers\User\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Auth\Events\Verified;
use App\Models\User;
use App\Http\Requests\EmailVerificationRequestApi;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Registered;
class EmailVerificationController extends ApiController
{
    public function sendEmailVerification(Request $request)
    {  
        if ($request->user()->hasVerifiedEmail()) {
            return $this->respondUnprocessableEntity("Email Already Verified");
        }
        
    
            $url= URL::temporarySignedRoute(
                'verification.verifyUserLogin',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $request->user()->getKey(),
                    'hash' => sha1($request->user()->getEmailForVerification()),
                    'unityReq'=>0
                ]
            );
            $request->user()->verifyUrl=$url;
            $request->user()->save();
            return $this->respondSuccessDataMessage($url, "Email Verification Sended");
       
    }
    public function resendEmailVerification(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->respondUnprocessableEntity("Email Already Verified");
        }
        event(new Registered($request->user()));
        $url= URL::temporarySignedRoute(
            'verification.verifyUserLogin',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $request->user()->getKey(),
                'hash' => sha1($request->user()->getEmailForVerification()),
                'unityReq'=>0
            ]
        );
        $request->user()->verifyUrl=$url;
        $request->user()->save();
        return $this->respondSuccessDataMessage($url, "Email Verification Sended");
    }
  


    public function verifyUserLogin(EmailVerificationRequestApi $request)
    {
     
        auth()->loginUsingId($request->route('id'));
        if ($request->user()->hasVerifiedEmail()) {
            if($request->route('unityReq')=="0")
            {
                return $this->respondUnprocessableEntity("Email Already Verified");

            }
            else
            {
                return view("verify-error");
             }
        }   

        if ($request->user()->markEmailAsVerified()) {
           event(new Verified($request->user()));
        }
        
        if($request->route('unityReq')=="0"){
            return $this->respondSuccessMessage("User Verified correct");    
        }
        else
        {
            return view("verify-success");
        
        }
    }
    //Todo Change to view 
  
}

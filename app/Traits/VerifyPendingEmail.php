<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\Exceptions\InvalidVerificationLinkException;

trait VerifyPendingEmail
{
    /**
     * Mark the user's new email address as verified.
     *
     * @param  string $token
     *
     * @throws \ProtoneMedia\LaravelVerifyNewEmail\Http\InvalidVerificationLinkException
     */
    public function verify(string $token)
    {
        
        $user = app(config('verify-new-email.model'))->whereToken($token)->firstOr(['*'], function () {
            
            throw new InvalidVerificationLinkException(
                __('The verification link is not valid anymore.')
            );
        })->tap(function ($pendingUserEmail) {
            $pendingUserEmail->activate();
        })->user;
        
        if (config('verify-new-email.login_after_verification')) {
            
            return Auth::guard()->login($user, config('verify-new-email.login_remember'));
        }
        
        return $this->authenticated();
    }
    public function verifyUnity(string $token)
    {
        $user = app(config('verify-new-email.model'))->whereToken($token)->first();
        if($user==null)
        {
           return $this->respondWithError("The verification link is not valid anymore.");
        }
     
        $user->activate();
  return    $this->respondSuccessMessage("Email Verified Correct");
        
       
        
        
    }
    protected function authenticated()
    {
        return redirect(config('verify-new-email.redirect_to'))->with('verified', true);
    }
       /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markNewEmailAsVerified()
    {
        return $this->forceFill([
            'new_email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }
}
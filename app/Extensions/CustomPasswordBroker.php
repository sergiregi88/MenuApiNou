<?php 
namespace App\Extensions;
use Illuminate\Support\Facades\Password;
use Closure;
/* 
@method static string sendResetLink(array $credentials, \Closure $callback = null)
*/
class CustomPasswordBroker extends \Illuminate\Auth\Passwords\PasswordBroker
{
  
    public  function sendResetLinUnityk(array $credentials, Closure $callback = null)
    {
        // First we will check to see if we found a user at the given credentials and
        // if we did not we will redirect back to this current URI with a piece of
        // "flash" data in the session to indicate to the developers the errors.
        $user = $this->getUser($credentials);

        if (is_null($user)) {
            return [Password::INVALID_USER,null];
        }

        if ($this->tokens->recentlyCreatedToken($user)) {
            return [Password::RESET_THROTTLED,null];
        }

        $token = $this->tokens->create($user);

        if ($callback) {
            return [Password::RESET_LINK_SENT,$callback($user, $token)];

        } else {
            // Once we have the reset token, we are ready to send the message out to this
            // user with a link to reset their password. We will then redirect back to
            // the current URI having nothing set in the session to indicate errors.
            $user->sendPasswordResetNotification($token);
        }

        return Password::RESET_LINK_SENT;
    
  }
}
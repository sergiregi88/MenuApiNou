<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Exception;
class InvalidVerificationLinkException extends Exception
{
    
    public function render($request)
    {
 return response()->view('error', ["message"=>$this->getMessage()], 200);
    }
}
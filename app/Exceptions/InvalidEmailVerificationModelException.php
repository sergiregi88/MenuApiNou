<?php

namespace App\Exceptions;

use Exception;

class InvalidEmailVerificationModelException extends Exception
{
    public function render($request)
    {
 return response()->view('error', ["message"=>$this->getMessage()], 200);
    }
}
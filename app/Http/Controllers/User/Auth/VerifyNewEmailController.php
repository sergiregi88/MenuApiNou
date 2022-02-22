<?php

namespace App\Http\Controllers\User\Auth;
use App\Traits\VerifyPendingEmail;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class VerifyNewEmailController extends ApiController
{
     /*
    |--------------------------------------------------------------------------
    | Verify New Email Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for verifying and activating new user email
    | addresses and uses a simple trait to include this behavior.
    |
    */

    use VerifyPendingEmail;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('throttle:6,1');
    }
}

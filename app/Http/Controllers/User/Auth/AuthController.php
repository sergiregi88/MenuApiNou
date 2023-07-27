<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\VerifyEmailCustom;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
class AuthController extends ApiController
{
    public function register(Request $request){
        
        $validator = Validator::make($request->all(),[
            "username"=>"required|string",
            "email"=>"required|string|unique:users,email",
            "password"=>"required|string|confirmed",
        ]);
        
        if ($validator->fails()) {
            return $this->respondValidationErrors($validator);
        }
        $validator = new EmailValidator();
$multipleValidations = new MultipleValidationWithAnd([
    new RFCValidation(),
    new DNSCheckValidation()
]);
//ietf.org has MX records signaling a server with email capabilities
    if(!$validator->isValid($request->email, $multipleValidations)) //true
        return $this->respondValidationErrorsStr(json_decode('{"email":["The email dns is not valid." ]}'));
        
        $user=User::create([
            "username"=>$request->username,
            "email"=>$request->email,
            "password"=>bcrypt($request->password),
        ]);
        $token=$user->createToken("token")->plainTextToken;

       
        event(new Registered($user));
        event(new Login($request->guard,$user,null));
        $user->Details()->create();
        $user->Stats()->create();
    
        $response=[
            "token"=>$token,
            "user"=>$user,
            'verifyUrl'=>VerifyEmailCustom::$verificationUrl,
        ];
        return $this->respondSuccessDataMessage($response,"User Registered Correcly");
    }
    public function login(Request $request){
         $validator = Validator::make($request->all(),[
            "identifier"=>"required|string|email",
            "password"=>"required|string",
        ]);
        $user=User::where('email',$request->identifier)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
            return  $this->respondUnauthorizedError("Bad Creedentials");
           }
     
       
        $token=$user->createToken("token")->plainTextToken;

        $response=[
            "token"=>$token,
            "user"=>$user,
        ];
        event(new Login($request->guard,$user,null));
        return $this->respondSuccessDataMessage($response);
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        $this->respondSuccessMessage("Logout Success");
    }
}

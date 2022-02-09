<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\VerifyEmail;

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
        $var=explode("@", $request->email);
        if(!checkdnsrr(array_pop($var),"MX")){
            return $this->respondValidationErrorsStr(json_decode('{"email":["The email dns is not valid." ]}'));
        }
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
            'verifyUrl'=>VerifyEmail::$urlToSend,
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
        //if($user->email_verified_at==null){
         //   return $this->respondUnauthorizedError("Need to verify account. Check email box!!");
        //}
       
        $token=$user->createToken("token")->plainTextToken;

        $response=[
            "token"=>$token,
            "user"=>$user,
        ];
        event(new Login($request->guard,$user,null));
        return $this->respondSuccessDataMessage($response);
    }
}

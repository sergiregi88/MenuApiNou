<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\UserDetails;
use App\Models\UserStats;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
class UserDetailsAndStatsController extends ApiController
{
    public function GetData(Request $request){
        
     return   $this->respondData([
            'UserDetails'=>UserDetails::where("user_id",auth()->user()->id)->first(),
            'UserStats'=>UserStats::where("user_id",auth()->user()->id)->first()
        ]);
    }
    public function UpdateUserStats(Request $request){
        $validator = Validator::make($request->all(),[
            "experience"=>"required|integer",
            "level"=>"required|integer",
            "faction"=>"required|string",
        ]);
        if ($validator->fails()) {
            return $this->respondValidationErrors($validator);
        }
        UserStats::where("user_id",auth()->user()->id)->update([
            "experince"=>$request->exp,
            "level"=>$request->level,
            "faction"=>$request->faction
        ])->save();
        return $this->respondSuccessMessage("Stats Updated ok");
    }
    public function UpdateUserDetails(Request $request){
        $validator = Validator::make($request->all(),[
            "firstName"=>"nullable|string",
            "level"=>"required|integer",
            "faction"=>"required|string",
        ]);
        if ($validator->fails()) {
            return $this->respondValidationErrors($validator);
        }
        UserDetails::where("user_id",auth()->user()->id)->update([
            "firstName"=>$request->firstName,
            "secondName"=>$request->secondname,
            "address"=>$request->address
        ])->save();
        return $this->repondSuccessMessage("Details Updated ok");
    }
    public function UpdateUserData(Request $request){
        
        auth()->user()->username=$request->username;
        auth()->user()->save();
        return $this->respondSuccessMessage("Data Updated ok");
    }
    public function UpdateUserEmail(Request $request){

    
        $validator = Validator::make($request->all(),[
            "email"=>"required|email|string|confirmed",
        ]);
        if ($validator->fails()) {
            return $this->respondValidationErrors($validator);
        }
        $var=explode("@", $request->email);
        if(!checkdnsrr(array_pop($var),"MX")){
            return $this->respondValidationErrorsStr(json_decode('{"email":["The email dns is not valid." ]}'));
        }
        if(auth()->user()->email===$request->email)
        {
            return $this->respondValidationErrorsStr(json_decode('{"email":["This email '.$request->email.' is not valid." ]}'));
        }
        auth()->user()->newEmail($request->email);
        auth()->user()->new_email_verified_at=null;
        auth()->user()->save();
        
        //TODO return  view mesage go to email or resend 
    }
    public function UpdateUserEmailUnity(Request $request){

        $validator = Validator::make($request->all(),[
            "email"=>"required|email|string|confirmed",
        ]);
        if ($validator->fails()) {
            return $this->respondValidationErrors($validator);
        }
        $var=explode("@", $request->email);
        if(!checkdnsrr(array_pop($var),"MX")){
            return $this->respondValidationErrorsStr(json_decode('{"email":["The email dns is not valid." ]}'));
        }
        if(auth()->user()->email===$request->email)
        {
            return $this->respondValidationErrorsStr(json_decode('{"email":["This email '.$request->email.' is not valid is your current email." ]}'));
        }
    
        $d=auth()->user()->newEmail($request->email);
        $url=$d->verificationUrl("1");
        auth()->user()->new_email_verified_at=null;
        auth()->user()->verifyUrl=$url;
        auth()->user()->save();
        
        return   $this->respondSuccessDataMessage($url,"Go to email box. or click the button Confirm Email");
       
    }
    public function ResendUpdateUserEmailUnity(Request $request){

        $d=auth()->user()->resendPendingEmailVerificationMail();
        if($d==null)
        {
            return $this->respondWithError("User not has a new email");
        }
        $url=$d->verificationUrl("1");
        auth()->user()->verifyUrl=$url;
        auth()->user()->save();
        return $this->respondSuccessDataMessage($url,"Go to email box. or click the button Confirm Email");
       
    }
    public function UpdateUserPassword(Request $request){
        $validator = Validator::make($request->all(),[
            "password"=>"required|string|confirmed",
        ]);
        if ($validator->fails()) {
            return $this->respondValidationErrors($validator);
        }
        auth()->user()->password=bcrypt($request->password);
        return $this->respondSuccessMessage("password Updated ok");
    }
}

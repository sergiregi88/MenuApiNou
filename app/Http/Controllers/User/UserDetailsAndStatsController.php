<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\UserDetails;
use App\Models\UserStats;
class UserDetailsAndStatsController extends ApiController
{
    public function GetData(Request $request){
        
     return   $this->respondData([
            'userDetails'=>UserDetails::where("user_id",auth()->user()->id)->first(),
            'userStats'=>UserStats::where("user_id",auth()->user()->id)->first()
        ]);
    }
}

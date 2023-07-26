<?php

namespace App\Http\Controllers\NoUser;

use App\Http\Controllers\ApiController;
use App\Http\Resources\GameDataResource;    
use App\Models\GameData\GameData;
use Illuminate\Http\Request;

class GameDataController extends ApiController
{
    public function CreateGetUniqueGameData(){
        
    
        // check if there are game data with id null.
        $gameData= new GameDataResource(GameData::where("user_id",NULL)->first());
       //1  $gameData=GameData::where("user_id",NULL)->first();
        if($gameData!=NULL){
           return $this->respondSuccessDataMessage($gameData,"OkOk");
        }
       

        $gameDataReturn=new GameDataResource(GameData::create(["user_id"=>NULL]));
        return $this->respondSuccessDataMessage($gameDataReturn,"Ok");
    }
    public function UpdateUniqueGameData(Request $request){
        $gameData= new GameDataResource(GameData::where("user_id",NULL)->first());
        
    }
    public function GetGameDataSlotsResume(){
        // Get 
    }
    public function GetGameDataParameters(){

    }
    
}

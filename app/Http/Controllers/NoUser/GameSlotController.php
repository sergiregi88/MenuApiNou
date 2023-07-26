<?php

namespace App\Http\Controllers\NoUser;

use App\Http\Controllers\ApiController;
use App\Http\Resources\GameActorDataResource;
use Illuminate\Http\Request;
use App\Models\GameSlot\SlotGameData;
use App\Http\Resources\SlotGameDataResource;
use App\Models\GameSlot\GameActorData;

class GameSlotController extends ApiController
{
    public function GetGameSlotData($id){

        $data=new SlotGameDataResource(SlotGameData::where("game_slot_resume_id",$id)->first());
        
        return $this->respondSuccessDataMessage($data,"Success");
        
      
         }
    public function StoreGameSlotData(){
        
    }
    public function PutGameSlotData(Request $request,$id)
    {
        
        
    }
}

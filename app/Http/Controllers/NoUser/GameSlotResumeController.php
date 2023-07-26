<?php

namespace App\Http\Controllers\NoUser;
use App\Http\Controllers\ApiController;
use App\Models\GameData\GameData;
use App\Models\GameSlot\GameSlotResumes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class GameSlotResumeController extends ApiController
{
    public function CreateGameSlotResume(){
        $validator = Validator::make(request()->all(),[
            "currentLevelPlay"=>"required|string",
            "title"=>"required|string",
            "gameDificulty"=>"required|integer",
            "typeSaveSlot"=>"required|integer",
            "dateTimeSaved"=>"required|date",  
            "timerofPlay"=>"required|integer",  
            'screenshot'=>"sometimes|file",
            

        ]);
        
        if ($validator->fails()) {
            return $this->respondValidationErrors($validator);
        }
        



        $newGameSlotResume=GameSlotResumes::create([
            "currentLevelPlay"=>request()->currentLevelPlay,
            "title"=>request()->title,
            "gameDificulty"=>request()->gameDificulty,
            "typeSaveSlot"=>request()->typeSaveSlot,
            "dateTimeSaved"=>request()->dateTimeSaved,
            "timePlayed"=>request()->timerofPlay,
           "game_data_id"=>NULL,
           // "user_id"=>NULL,
        ]);

        if(request()->hasFile("screenshot")){
            
            $fileName=request()->file("screenshot")->hashName();
            request()->file("screenshot")->storeAs("NoUserscreenshots",$fileName,"public");

            $newGameSlotResume->update(["screenshot"=>$fileName]);
            $newGameSlotResume->save();
        }
       // return  url()->to('/')."/storage/NoUserscreenshots/".$newGameSlotResume->screenshot;
    }

    public function GetAllGameSlotsResumes()
    {
        $gameData=GameData::where("user_id",NULL)->first();
        $gameSlots=GameSlotResumes::where("game_data_id",NULL)->get();
        return $this->respondSuccessDataMessage($gameSlots);
    }
}

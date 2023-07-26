<?php

namespace App\Http\Resources;

use App\Models\GameSlot\GameSlotResumeData;
use Illuminate\Http\Resources\Json\JsonResource;

class GameSlotResumeInfoResource extends JsonResource
{
    public $collects = GameSlotResumeData::class;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "currentLevelPlay"=>$this->currentLevelPlay,
            "title"=>$this->title,
            "dateTimeCreated"=>$this->created_on,
            "typeSaveSlot"=>$this->typeSaveSlot,
            "gameDificulty"=>$this->gameDificulty,
            "dateTimeSaved"=>$this->dateTimeSaved,
            "timePlayed"=>$this->timePlayed,
        ];
    }
}

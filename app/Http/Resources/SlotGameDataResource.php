<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SlotGameDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            //"NumObj"=>count(GameActorDataResource::collection($this->GameActorsOfSlot)),
            "ObjectsToSaveInSlot"=>GameActorDataResource::collection($this->GameActorsOfSlot),
           "health"=>$this->health,
           "id"=>$this->id,
            
        ];
    }
}

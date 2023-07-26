<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameActorDataResource extends JsonResource
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
            'id' => $this->id,
            'game_slot_id'=>$this->game_slot_id,
            'name' => $this->name,
          //  'transformSTR' => $this->Transform,
            'transform'=>new TrasformComponentDataResource($this->GetTrasformComponent),
            'prefabPath'=>$this->prefabPath,
            // TODO depend of administrator or nou role get the 
          /*   'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at, */
        ];
    }
}

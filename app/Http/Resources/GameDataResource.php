<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameDataResource extends JsonResource
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
            "listSlotsResumes"=>GameSlotResumeInfoResource::collection($this->GameSlotsResumes),
            'Parameters'=>new GameParametersResource($this->GameParameters),
            'previousSlotLoaded'=>NULL
        ];
    }
}

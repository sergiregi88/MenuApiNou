<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrasformComponentDataResource extends JsonResource
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
        "position"=>json_decode($this->position),
        "rotation"=>json_decode($this->rotation),
        "scale"=>json_decode($this->scale),
        'isActive'=>$this->isActive,
        'isStatic'=>$this->isStatic,
        'staticFlag'=>$this->staticFlag,
        'layerMask'=>$this->layerMask,
        'tag'=>$this->tag,
        ];
    }
}

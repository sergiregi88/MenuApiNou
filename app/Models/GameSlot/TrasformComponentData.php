<?php

namespace App\Models\GameSlot;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrasformComponentData extends Model
{
    protected $table ='transform_component_data';
    use HasFactory;
    protected $fillable = [
        'id',
        'slot_actor_id',
        "position",
        "rotation",
        "scale",
        "isActive",
        "isStatic",
        'tag',
        'layerMask',
        'staticFlag'


    ];
    protected $visible=['id'];

    public function GetActorData(){
        return $this->belongsTo(GameActorData::class);
    }
}

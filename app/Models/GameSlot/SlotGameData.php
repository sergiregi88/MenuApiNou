<?php

namespace App\Models\GameSlot;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlotGameData extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        'slot_id',
        "Transform",
        "prefabPath",
        "name",

    ];
    
    public function GameActorsOfSlot(){
        return $this->hasMany(GameActorData::class,"slot_game_id","id");
    }
}

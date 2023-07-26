<?php

namespace App\Models\GameSlot;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameActorData extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'slot_game_id',
    ];
    protected $visible=['id'];
    public function GetSlotData(){
        return $this->belongsTo(SlotGameData::class,"slot_game_id");
    }
    public function GetTrasformComponent(){
        return $this->hasOne(TrasformComponentData::class,"slot_actor_id","id");
    }
}

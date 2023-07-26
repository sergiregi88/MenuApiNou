<?php

namespace App\Models\GameSlot;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSlotResumes extends Model
{
    use HasFactory;

    protected $fillable = [
        'currentLevelPlay',
        'title',
        'gameDificulty',
        'typeSaveSlot',
        'dateTimeSaved',
        'screenshot',
        'user_id',
    ];
    protected $visible=['id',"title","currentLevelPlay","gameDificulty",'typeSaveSlot',
    'dateTimeSaved',
    'screenshot'];
    public function GameData(){
        return $this->belongsTo(GameData::class,"game_data_id","id");
    }
}

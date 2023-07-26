<?php

namespace App\Models\GameData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameParameters extends Model
{
    use HasFactory;
    public function GameData(){
        return $this->belongsTo(GameData::class);
    }
    public function audio(){
        return ["sssss"=>"ss"];
    }
}

<?php

namespace App\Models\GameData;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GameSlot\GameSlotResumes;
use App\Models\User;    
use App\Models\GameData\GameParameters;

class GameData extends Model
{
    use HasFactory;
    public function User(){
       return $this->hasOne(User::class,"user_id","id");
    }
    public function GameSlotsResumes(){
        return $this->hasMany(GameSlotResumes::class,"game_data_id","id");
    }
    public function GameParameters(){
        return $this->hasOne(GameParameters::class);
    }
    protected $fillable = [
       "user_id",
    ];
}

<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class UserStats extends Model
{
    use HasFactory;

    
    function User(){
      return  $this->belongsTo(User::class);
        }
}

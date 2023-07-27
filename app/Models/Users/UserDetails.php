<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class UserDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstName',
    
    
    ];
    function User(){
   return $this->belongsTo(User::class);
    }
}

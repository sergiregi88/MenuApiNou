<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\SendEmailConfirmVerificationNotification;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'last_sign_in_at',
        'current_sign_in_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates=[
        'current_sign_in_at','last_sign_in_at'
    ];

    public function sendPasswordResetNotification($token)
    {
        $url="http://localhost/api/v1/user/reset-password/".$token;
        $this->notify(new ResetPasswordNotification($url));
    }
    public function sendConfirmVerificationEmail(){
        $this->notify(new SendEmailConfirmVerificationNotification($this));
    }
}

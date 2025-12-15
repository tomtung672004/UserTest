<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Job extends Model implements JWTSubject
{
     use HasApiTokens, HasFactory, Notifiable;
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function user()
    {
        return $this->hasMany(User::class);
    }
    protected $fillable = [
        'title',
        'description',
        'location',
        'salary',
    ];
    protected $hidden = [

    ];
    public function getJWTCustomClaims()
    {
        return [];
    }
}

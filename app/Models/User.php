<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticable implements JWTSubject
{
    protected $fillable = ['fullname', 'username', 'password'];

    protected $hidden = ['password'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
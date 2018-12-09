<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $casts = [
        'group' => 'integer'
    ];

    const MEMBER = 0;
    const PRODUCT_OWNER = 1;
    const SCRUM_MASTER = 2;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function scopeExecutors($query)
    {
        return $query->where('group', self::MEMBER);
    }

    public function isProductOwner()
    {
        return $this->group === self::PRODUCT_OWNER;
    }

    public function isMember()
    {
        return $this->group === self::MEMBER;
    }

    public function isScrumMaster()
    {
        return $this->group === self::SCRUM_MASTER;
    }
}

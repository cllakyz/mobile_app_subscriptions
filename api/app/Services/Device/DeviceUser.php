<?php

namespace App\Services\Device;

use Illuminate\Contracts\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Cache;

class DeviceUser implements Authenticatable, JWTSubject
{
    const CACHE_PRE = 'device_user';

    public $id;
    public $uid;
    public $appId;
    public $language;
    public $operation_system;
    public $remember_token;
    public $uniqueIdentifier;
    protected $password;

    public function getAuthIdentifierName(): string
    {
        return 'uniqueIdentifier';
    }

    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    public function getAuthPassword(): string
    {
        return $this->password;
    }

    public function setAuthPassword($password)
    {
        $this->password = $password;
    }

    public function getRememberToken(): string
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;

        Cache::put(self::CACHE_PRE . $this->uniqueIdentifier, $this);
    }

    public function getRememberTokenName(): string
    {
        return 'remember_token';
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return string
     */
    public function getJWTIdentifier(): string
    {
        return $this->uid . $this->appId;
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}

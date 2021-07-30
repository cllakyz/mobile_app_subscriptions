<?php

namespace App\Services\Device;

use App\Services\DeviceService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider as DeviceUserProviderContract;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;

class DeviceUserProvider implements DeviceUserProviderContract
{
    private $deviceService;

    public function __construct(DeviceService $deviceService)
    {
        $this->deviceService = $deviceService;
    }

    public function retrieveById($identifier)
    {
        return Cache::get(DeviceUser::CACHE_PRE . $identifier);
    }

    public function retrieveByCredentials(array $credentials)
    {
        $uid = Arr::get($credentials, 'u_id');
        $appId = Arr::get($credentials, 'app_id');

        $cacheKeyWithUidAppId = DeviceUser::CACHE_PRE . hash('sha256', $uid . $appId);

        $cachedUser = Cache::get($cacheKeyWithUidAppId);
        if(!empty($cachedUser)){
            return $cachedUser;
        }

        $deviceData = $this->deviceService->register($credentials);
        $user = new DeviceUser();

        $user->id = $deviceData->id;
        $user->uid = $deviceData->u_id;
        $user->appId = $deviceData->app_id;
        $user->operation_system = $deviceData->operating_system;
        $user->language = $deviceData->language;
        $user->uniqueIdentifier = $deviceData->u_id.$deviceData->app_id;

        $user->setAuthPassword(hash('sha256', $appId.$uid));

        $cacheTime = now()->minutes(env('JWT_TTL'));
        Cache::put($cacheKeyWithUidAppId, $user, $cacheTime);

        $cacheKeyWithUid = DeviceUser::CACHE_PRE . $uid . $appId;
        Cache::put($cacheKeyWithUid, $user, $cacheTime);

        return $user;
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        return true;
    }

    public function retrieveByToken($identifier, $token)
    {
        $user = Cache::get(DeviceUser::CACHE_PRE . $identifier);

        if (!$user) {
            return null;
        }

        $rememberToken = $user->getRememberToken();

        return $rememberToken && hash_equals($rememberToken, $token) ? $user : null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        $user->setRememberToken($token);
    }
}

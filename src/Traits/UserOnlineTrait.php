<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/19/2018
 * Time: 11:12 AM
 */

namespace Cloudteam\BaseCore\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

trait UserOnlineTrait
{
    public function getCachedAt()
    {
        if (empty($cache = Cache::get($this->getKeyCache()))) {
            return 0;
        }

        return $cache['cachedAt'];
    }

    public function isOnline()
    {
        return Cache::has($this->getKeyCache());
    }

    public function getKeyCache()
    {
        return sprintf('%s-%s', 'UserOnline', $this->id);
    }

    public function leastRecentOnline()
    {
        return $this->getAllOnline()
                    ->sortBy(static function ($user) {
                        return $user->getCachedAt();
                    });
    }

    public function getAllOnline()
    {
        return $this->all()->filter->isOnline();
    }

    public function mostRecentOnline()
    {
        return $this->getAllOnline()
                    ->sortByDesc(static function ($user) {
                        return $user->getCachedAt();
                    });
    }

    public function pullCache()
    {
        Cache::pull($this->getKeyCache());
    }

    public function setCache($minutes = 5)
    {
        Cache::put($this->getKeyCache(), $this->getCacheContent(), $minutes);
    }

    public function getCacheContent()
    {
        if ( ! empty($cache = Cache::get($this->getKeyCache()))) {
            return $cache;
        }
        $cachedAt = Carbon::now();

        return [
            'cachedAt' => $cachedAt,
            'user'     => $this,
        ];
    }
}
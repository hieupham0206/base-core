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
        if (empty($cache = Cache::get($this->getCacheKey()))) {
            return 0;
        }

        return $cache['cachedAt'];
    }

    public function isOnline()
    {
        return Cache::has($this->getCacheKey());
    }

    public function getCacheKey()
    {
        return sprintf('%s-%s', 'UserOnline', $this->id);
    }

    public function leastRecentOnline()
    {
        return $this->allOnline()
                    ->sortBy(function ($user) {
                        return $user->getCachedAt();
                    });
    }

    public function allOnline()
    {
        return $this->all()->filter->isOnline();
    }

    public function mostRecentOnline()
    {
        return $this->allOnline()
                    ->sortByDesc(function ($user) {
                        return $user->getCachedAt();
                    });
    }

    public function pullCache()
    {
        Cache::pull($this->getCacheKey());
    }

    public function setCache($minutes = 5)
    {
        Cache::put($this->getCacheKey(), $this->getCacheContent(), $minutes);
    }

    public function getCacheContent()
    {
        if ( ! empty($cache = Cache::get($this->getCacheKey()))) {
            return $cache;
        }
        $cachedAt = Carbon::now();

        return [
            'cachedAt' => $cachedAt,
            'user'     => $this,
        ];
    }
}
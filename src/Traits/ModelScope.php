<?php

namespace Cloudteam\BaseCore\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ModelScope
{
    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeInUse(Builder $query)
    {
        return $query->where('state', App\Enums\UseState::IN_USE);
    }
}

<?php

namespace Cloudteam\BaseCore\Facades;

use Illuminate\Support\Facades\Facade;

class BaseCore extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'basecore';
    }
}

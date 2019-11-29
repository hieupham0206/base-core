<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 4/4/2018
 * Time: 2:22 PM
 */

namespace Cloudteam\BaseCore\Traits;

use Cloudteam\BaseCore\Observers\ResponsibleObserver;

trait Responsible
{
    public static function bootResponsible()
    {
        self::observe(ResponsibleObserver::class);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 10/2/2018
 * Time: 11:57 AM
 */

namespace Cloudteam\BaseCore\Traits;

trait Modelable
{
    public function getCreatedAtAttribute($value): string
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    public function getConfirmationsAttribute()
    {
        return \Cloudteam\BaseCore\App\Enums\Confirmation::toSelectArray();
    }

    /**
     * @inheritdoc
     */
    public function getDescriptionEvent(string $eventName): string
    {
        $modelValName = '';
        if ( ! empty($this->{'name'})) {
            $modelValName = $this->{'name'};
        } elseif ( ! empty($this->{'code'})) {
            $modelValName = $this->{'code'};
        } elseif ( ! empty($this->{'title'})) {
            $modelValName = $this->{'title'};
        }

        if ($this->action) {
            $eventName = $this->action;
        }
        $user     = auth()->user();
        $username = $user ? $user->username : 'admin';

        return sprintf('%s %s%s %s. %s', __(ucfirst(static::$logName)), $modelValName, __(" has been {$eventName} by "), $username, $this->message);
    }
}
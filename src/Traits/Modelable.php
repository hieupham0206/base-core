<?php

namespace Cloudteam\BaseCore\Traits;

use Illuminate\Support\Str;

trait Modelable
{
    public function getCanBeCreatedAttribute()
    {
        $name = Str::singular($this->getTable());

        try {
            return can("create_$name");
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getCanBeEditedAttribute()
    {
        $name = Str::singular($this->getTable());

        try {
            return can("edit_$name");
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getCanBeDeletedAttribute()
    {
        $name = Str::singular($this->getTable());

        try {
            return can("delete_$name");
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getCreatedAtTextAttribute(): string
    {
        return $this->created_at->format(config('basecore.datetime_format', 'd-m-Y H:i:s'));
    }

    public function getUpdatedAtTextAttribute(): string
    {
        return $this->updated_at->format(config('basecore.datetime_format', 'd-m-Y H:i:s'));
    }

    /**
     * @inheritdoc
     */
    public function getDescriptionEvent(string $eventName): string
    {
        $displayAttribute = $this->displayAttribute;
        if ( ! empty($this->{$displayAttribute})) {
            $modelValName = $this->{$displayAttribute};
        } else {
            $modelValName = $this->{'name'};
        }

        if ($this->action) {
            $eventName = $this->action;
        }
        $user     = auth()->user();
        $username = $user ? $user->username : 'admin';

        return sprintf('%s %s%s %s. %s', __(ucfirst(static::$logName)), $modelValName, __(" has been {$eventName} by "), $username, $this->message);
    }
}
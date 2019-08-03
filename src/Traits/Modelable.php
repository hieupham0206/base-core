<?php

namespace Cloudteam\BaseCore\Traits;

use Illuminate\Support\Str;

trait Modelable
{
    public function getTableNameSingularAttribute()
    {
        return Str::singular($this->getTable());
    }

    public function getCanBeCreatedAttribute()
    {
        $name = $this->table_name_singular;

        try {
            return can("create_$name");
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getCanBeEditedAttribute()
    {
        $name = $this->table_name_singular;

        try {
            return can("edit_$name");
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getCanBeDeletedAttribute()
    {
        $name = $this->table_name_singular;

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
            $modelValName = $this->{'code'};
        }

        if ($this->action) {
            $eventName = $this->logAction;
        }
        $user     = auth()->user();
        $username = $user ? $user->username : 'admin';

        return sprintf('%s %s%s %s. %s', __(ucfirst(static::$logName)), $modelValName, __(" has been {$eventName} by "), $username, $this->logMessage);
    }
}

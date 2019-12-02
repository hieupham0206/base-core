<?php

namespace Cloudteam\BaseCore\Observers;

use Illuminate\Database\Eloquent\Model;

class ResponsibleObserver
{
    public function creating(Model $model)
    {
        if (blank($model->created_by)) {
            $model->created_by = auth()->check() ? auth()->id() : 1;
        }
    }

    public function updating(Model $model)
    {
        if (blank($model->updated_by)) {
            $model->updated_by = auth()->check() ? auth()->id() : 1;
        }
    }
}

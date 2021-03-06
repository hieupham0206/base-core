<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 4/4/2018
 * Time: 2:22 PM
 */

namespace Cloudteam\BaseCore\Traits;

use Cloudteam\BaseCore\Models\ActivityLog;
use function get_class;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait Responsible
{
    /**
     * Relation user tạo model
     * @return HasOne
     */
    public function createdBy()
    {
        return $this->hasOne(ActivityLog::class, 'subject_id')
                    ->with(['causer'])
                    ->where('subject_type', get_class($this))
                    ->where('description', 'like', '%' . __(' has been created by ') . '%')
                    ->orderBy('id', 'desc')->limit(1);
    }

    /**
     * Relation user update model
     * @return HasOne
     */
    public function updatedBy()
    {
        return $this->hasOne(ActivityLog::class, 'subject_id')
                    ->with(['causer'])
                    ->where('subject_type', get_class($this))
                    ->where('description', 'like', '%' . __(' has been updated by ') . '%')
                    ->orderBy('id', 'desc')->limit(1);
    }

    /**
     * Relation user delete model
     * @return HasOne
     */
    public function deletedBy()
    {
        return $this->hasOne(ActivityLog::class, 'subject_id')
                    ->with(['causer'])
                    ->where('subject_type', get_class($this))
                    ->where('description', 'like', '%' . __(' has been deleted by ') . '%')
                    ->orderBy('id', 'desc')->limit(1);
    }
}
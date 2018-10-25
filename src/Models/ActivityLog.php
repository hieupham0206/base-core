<?php

namespace Cloudteam\BaseCore\Models;

use Cloudteam\BaseCore\Traits\Queryable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ActivityLog
 *
 * @property int $id
 * @property string|null $log_name
 * @property string $description
 * @property int|null $subject_id
 * @property string|null $subject_type
 * @property int|null $causer_id
 * @property string|null $causer_type
 * @property string|null $properties
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $causer
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog andFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog dateBetween($dates, $column = 'created_at', $format = 'd-m-Y', $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog filters($filterDatas, $boolean = 'and', $filterConfigs = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog orFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereCauserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereCauserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereLogName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereSubjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereUpdatedAt($value)
 */
class ActivityLog extends Model
{
    use Queryable;

    protected $table = 'activity_log';

    public function causer()
    {
        return $this->belongsTo(User::class, 'causer_id')->withDefault();
    }
}

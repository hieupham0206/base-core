<?php

namespace Cloudteam\BaseCore\Models;

use App\Models\User;
use Cloudteam\BaseCore\Traits\Queryable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $causer
 * @method static Builder|ActivityLog andFilterWhere($conditions)
 * @method static Builder|ActivityLog dateBetween($dates, $column = 'created_at', $format = 'd-m-Y', $boolean = 'and', $not = false)
 * @method static Builder|ActivityLog filters($filterDatas, $boolean = 'and', $filterConfigs = null)
 * @method static Builder|ActivityLog orFilterWhere($conditions)
 * @method static Builder|ActivityLog whereCauserId($value)
 * @method static Builder|ActivityLog whereCauserType($value)
 * @method static Builder|ActivityLog whereCreatedAt($value)
 * @method static Builder|ActivityLog whereDescription($value)
 * @method static Builder|ActivityLog whereId($value)
 * @method static Builder|ActivityLog whereLogName($value)
 * @method static Builder|ActivityLog whereProperties($value)
 * @method static Builder|ActivityLog whereSubjectId($value)
 * @method static Builder|ActivityLog whereSubjectType($value)
 * @method static Builder|ActivityLog whereUpdatedAt($value)
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

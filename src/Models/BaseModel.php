<?php

namespace Cloudteam\BaseCore\Models;

use Cloudteam\BaseCore\Traits\{Labelable, Linkable, Modelable, Queryable};
use Illuminate\{Database\Eloquent\Builder, Database\Eloquent\Model};

/**
 * App\Models\BaseModel
 *
 * @property-read mixed $created_at_text
 * @method static Builder|BaseModel andFilterWhere($conditions)
 * @method static Builder|BaseModel dateBetween($dates, $column = 'created_at', $format = 'd-m-Y', $boolean = 'and', $not = false)
 * @method static Builder|BaseModel filters($filterDatas, $boolean = 'and', $filterConfigs = null)
 * @method static Builder|BaseModel orFilterWhere($conditions)
 */
class BaseModel extends Model
{
    use Labelable, Queryable, Linkable, Modelable;

    use \Spatie\Activitylog\Traits\LogsActivity;

    /**
     * Tên custom action dùng để lưu log hoạt động
     * @var string
     */
    public $logAction = '';

    /**
     * Custom message log
     * @var string
     */
    public $logMessage = '';

    /**
     * Column dùng để hiển thị cho model (Default là name)
     * @var string
     */
    public $displayAttribute = 'name';

    /**
     * Text hiển thị cho column
     * @var array
     */
    public $labels = [];

    /**
     * Định nghĩa các field cho filter
     * @var array
     */
    public $filters = [];

    /**
     * @inheritdoc
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return $this->getDescriptionEvent($eventName);
    }
}

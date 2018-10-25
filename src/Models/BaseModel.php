<?php

namespace Cloudteam\BaseCore\Models;

use Cloudteam\BaseCore\Traits\Labelable;
use Cloudteam\BaseCore\Traits\Linkable;
use Cloudteam\BaseCore\Traits\Modelable;
use Cloudteam\BaseCore\Traits\Queryable;
use Cloudteam\BaseCore\Traits\Responsible;

/**
 * App\Models\BaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel andFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel dateBetween($dates, $column = 'created_at', $format = 'd-m-Y', $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel filters($filterDatas, $boolean = 'and', $filterConfigs = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel orFilterWhere($conditions)
 */
class BaseModel extends \Illuminate\Database\Eloquent\Model
{
    use Responsible, Labelable, Queryable, Linkable, Modelable;

    /**
     * Tên custom action dùng để lưu log hoạt động
     * @var string
     */
    public $action = '';

    /**
     * Custom message log
     * @var string
     */
    public $message = '';

    /**
     * Route của model dùng cho Linkable trait
     * @var string
     */
    public $route = '';

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
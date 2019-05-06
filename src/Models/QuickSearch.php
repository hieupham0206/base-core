<?php

namespace Cloudteam\BaseCore\Models;

use Cloudteam\BaseCore\Traits\Searchable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\QuickSearch
 *
 * @property int $id
 * @property string|null $model_type Loại model lưu để index
 * @property string|null $route
 * @property string $search_text
 * @method static Builder|BaseModel andFilterWhere($conditions)
 * @method static Builder|BaseModel dateBetween($dates, $column = 'created_at', $format = 'd-m-Y', $boolean = 'and', $not = false)
 * @method static Builder|BaseModel filters($filterDatas, $boolean = 'and', $filterConfigs = null)
 * @method static Builder|BaseModel orFilterWhere($conditions)
 * @method static Builder|QuickSearch search($term)
 * @method static Builder|QuickSearch whereId($value)
 * @method static Builder|QuickSearch whereModelType($value)
 * @method static Builder|QuickSearch whereRoute($value)
 * @method static Builder|QuickSearch whereSearchText($value)
 * @mixin Eloquent
 */
class QuickSearch
{
    use Searchable;

    protected $table = 'quick_searchs';
    public $timestamps = false;

    protected $casts = [
        'model_id' => 'int'
    ];

    protected $fillable = [
        'search_text',
        'model_type',
        'route',
    ];

    protected $searchable = [
        'search_text'
    ];
}

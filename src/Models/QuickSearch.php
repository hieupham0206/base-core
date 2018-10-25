<?php

namespace Cloudteam\BaseCore\Models;

use Cloudteam\BaseCore\Traits\Searchable;

/**
 * App\Models\QuickSearch
 *
 * @property int $id
 * @property string|null $model_type Loại model lưu để index
 * @property string|null $route
 * @property string $search_text
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel andFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel dateBetween($dates, $column = 'created_at', $format = 'd-m-Y', $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel filters($filterDatas, $boolean = 'and', $filterConfigs = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel orFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickSearch search($term)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickSearch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickSearch whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickSearch whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuickSearch whereSearchText($value)
 * @mixin \Eloquent
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

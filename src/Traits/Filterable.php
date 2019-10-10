<?php
/**
 * User: ADMIN
 * Date: 03/10/2019 2:46 CH
 */

namespace Cloudteam\BaseCore\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait Filterable
{
    private $conditions = [];

    /**
     * @param $configs
     * @param string $boolean
     *
     * @return void
     */
    private function addCondition($configs, $boolean = 'and'): void
    {
        [$column, $operator, $value] = $configs;

        if ( ! isValueEmpty($value)) {
            [$column, $isForeignKey, $relation, $value, $table] = $this->preparedParam($operator, $column, $value);

            $this->conditions[] = [$column, $value, $boolean, $operator, $isForeignKey, $relation, $table];
        }
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    private function build(Builder $query)
    {
        return $query->where(function (Builder $subQuery) {
            foreach ($this->conditions as $condition) {
                [$column, $value, $boolean, $operator, $isForeignKey, $relation, $table] = $condition;
                if ($isForeignKey) {
                    $subQuery->whereHas($relation, static function (Builder $q) use ($column, $value, $operator, $boolean, $table) {
                        if (is_array($value)) {
                            $q->whereIn($column, $value, $boolean, $operator === '!=');
                        } else {
                            $q->where("$table.$column", $operator, $value, $boolean);
                        }
                    });
                } else {
                    if (is_array($value) && $value) {
                        $subQuery->whereIn($column, $value, $boolean, $operator === '!=');
                    }

                    $subQuery->where($column, $operator, $value, $boolean);
                }
            }

            return $subQuery;
        });
    }

    /**
     * @param $operator
     * @param $column
     * @param $value
     *
     * @return array
     */
    private function preparedParam($operator, $column, $value): array
    {
        $isForeignKey = $relation = false;
        $table        = '';
        if (strpos($column, '.') !== false) {
            $columns = explode('.', $column);
            $column  = array_pop($columns);

            $isForeignKey = true;
            $relation     = implode('.', $columns);

            $callClass  = static::class;
            $classNames = explode('\\', $callClass);
            $className  = end($classNames);
            $tableName  = Str::plural(Str::snake($className));

            if ($tableName === $relation) {
                $isForeignKey = false;
                $column       = "$relation.$column";
            }
        }

        if (strtolower($operator) === 'like') {
            $value = "%$value%";
        }

        return [$column, $isForeignKey, $relation, $value, $table];
    }
}

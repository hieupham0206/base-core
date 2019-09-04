<?php

namespace Cloudteam\BaseCore\Traits;

use Cloudteam\BaseCore\Models\QuickSearch;
use Illuminate\Database\Eloquent\Builder;
use ReflectionClass;
use function strlen;
use Illuminate\Support\Str;

trait Searchable
{
    public static function bootSearchable(): void
    {
        static::created(static function ($model) {
            $searchText = '';
            if ( ! empty($model->name)) {
                $searchText = $model->name;
            } elseif ( ! empty($model->{'code'})) {
                $searchText = $model->{'code'};
            } elseif ( ! empty($model->username)) {
                $searchText = $model->{'username'};
            }
            $reflect   = new ReflectionClass($model);
            $tableName = Str::plural(Str::snake($reflect->getShortName()));

            if ($searchText !== '') {
                $datas = [
                    'search_text' => $searchText,
                    'route'       => route("{$tableName}.show", $model->id),
                    'model_type'  => $reflect->name,
                ];

                QuickSearch::create($datas);
            }
        });

        static::deleted(static function ($model) {
            $reflect   = new ReflectionClass($model);
            $tableName = Str::plural(Str::snake($reflect->getShortName()));

            QuickSearch::query()->where([
                'route' => route("{$tableName}.show", $model->id)
            ])->delete();
        });
    }

    /**
     * Replaces spaces with full text search wildcards
     *
     * @param string $term
     *
     * @return string
     */
    protected function fullTextWildcards($term): string
    {
        // removing symbols used by MySQL
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term            = str_replace($reservedSymbols, '', $term);

        $words = explode(' ', $term);

        foreach ($words as $key => $word) {
            $words[$key] = $word . '*';
            /*
             * applying + operator (required word) only big words
             * because smaller ones are not indexed by mysql
             */
            if (strlen($word) >= 3) {
                $words[$key] = '+' . $word . '*';
            }
        }

        return implode(' ', $words);
    }

    /**
     * Scope a query that matches a full text search of term.
     *
     * @param Builder $query
     * @param string $term
     *
     * @return Builder
     */
    public function scopeSearch($query, $term): Builder
    {
        $columns = implode(',', $this->searchable);

        $query->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)", $this->fullTextWildcards($term));

        return $query;
    }
}

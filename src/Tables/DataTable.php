<?php

namespace Cloudteam\BaseCore\Tables;

/**
 * Class DataTable
 * @property integer $draw
 * @property integer $length
 * @property integer $start
 * @property mixed $searchValue
 * @property integer $column
 * @property string $direction
 * @property integer $totalRecords
 * @property integer $totalFilteredRecords
 * @property array $data
 * @property array $filters
 * @property boolean $isFilterNotEmpty
 */
abstract class DataTable
{
    public $draw = 1;
    public $length = 10;
    public $start = 0;
    public $searchValue = '';
    public $column = 'id';
    public $direction = 'desc';
    public $totalRecords = 0;
    public $totalFilteredRecords = 0;
    public $filters = [];
    public $isFilterNotEmpty = false;
    public $data = [];

    public function __construct(array $args = null)
    {
        $arguments         = $args ?? request()->post();
        $this->draw        = $arguments['draw'];
        $this->length      = ! isset($arguments['length']) || $arguments['length'] < 0 ? 10 : $arguments['length'];
        $this->start       = $arguments['start'];
        $this->searchValue = $arguments['search']['value'];
        if (array_key_exists('data', $arguments)) {
            $this->data = $arguments['data'];
        }
        if (array_key_exists('order', $arguments)) {
            $this->column    = $arguments['order'][0]['column'];
            $this->direction = $arguments['order'][0]['dir'];
        }
        if (array_key_exists('filters', $arguments)) {
            $filters       = json_decode($arguments['filters'], JSON_FORCE_OBJECT);
            $finalFilters = [];
            foreach ($filters as $filter) {
                if (isset($finalFilters[$filter['name']])) {
                    $currentVal = is_array($finalFilters[$filter['name']]) ? $finalFilters[$filter['name']] : [$finalFilters[$filter['name']]];
                    $finalFilters[$filter['name']] = array_merge([$filter['value']], $currentVal);
                } else {
                    $finalFilters[$filter['name']] = $filter['value'];
                }
            }
            $this->filters = $finalFilters;
        }

        $this->isFilterNotEmpty = collect($this->filters)->filter()->isNotEmpty();
    }

    abstract public function getData(): array;

    abstract public function getModels();

    public function getSortColumn(): string
    {
        return $this->column;
    }
}
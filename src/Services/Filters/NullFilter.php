<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;
use InovantiBank\AdvancedQueryFilters\Enums\FilterOperator;
use Illuminate\Database\Eloquent\Builder;
use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;

class NullFilter implements FilterInterface
{
    public function apply($query, $value)
    {
        $operator = FilterOperatorEnum::from($value['operator']);

        switch ($operator) {
            case FilterOperatorEnum::EQUAL:
                return $value['boolean'] ? $query->whereNull('field') : $query->whereNotNull('field');
            default:
                throw new \InvalidArgumentException("Invalid operator for NullFilter");
        }
    }
}

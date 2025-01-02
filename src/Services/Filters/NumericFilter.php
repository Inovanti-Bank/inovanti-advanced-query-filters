<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;

class NumericFilter implements FilterInterface
{
    public function apply($query, $value)
    {
        $operator = FilterOperatorEnum::from($value['operator']);

        return match ($operator) {
            FilterOperatorEnum::EQUAL => $query->where('field', '=', $value['number']),
            FilterOperatorEnum::GREATER_THAN => $query->where('field', '>', $value['number']),
            FilterOperatorEnum::LESS_THAN => $query->where('field', '<', $value['number']),
            FilterOperatorEnum::BETWEEN => $query->whereBetween('field', [$value['min'], $value['max']]),
            default => throw new \InvalidArgumentException('Invalid operator for NumericFilter')
        };
    }
}

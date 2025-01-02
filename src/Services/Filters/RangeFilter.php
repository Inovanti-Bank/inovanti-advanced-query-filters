<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;

class RangeFilter implements FilterInterface
{
    public function apply($query, $value)
    {
        $operator = FilterOperatorEnum::from($value['operator']);

        return match ($operator) {
            FilterOperatorEnum::BETWEEN => $query->whereBetween('field', [$value['min'], $value['max']]),
            FilterOperatorEnum::GREATER_THAN_OR_EQUAL => $query->where('field', '>=', $value['min']),
            FilterOperatorEnum::LESS_THAN_OR_EQUAL => $query->where('field', '<=', $value['max']),
            default => throw new \InvalidArgumentException('Invalid operator for RangeFilter')
        };
    }
}

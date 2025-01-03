<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;

class NumericFilter implements FilterInterface
{
    public function apply($query, $value)
    {
        $operator = FilterOperatorEnum::from($value['operator']);
        $column = $value['field'];

        if (! isset($value['number'])) {
            throw new InvalidArgumentException("Missing 'number' value for operator");
        }

        $number = $value['number'];

        return match ($operator) {
            FilterOperatorEnum::EQUAL => $query->where($column, '=', $number),
            FilterOperatorEnum::GREATER_THAN => $query->where($column, '>', $number),
            FilterOperatorEnum::LESS_THAN => $query->where($column, '<', $number),
            FilterOperatorEnum::BETWEEN => $query->whereBetween($column, [$value['min'], $value['max']]),
            default => throw new \InvalidArgumentException('Invalid operator for NumericFilter')
        };
    }
}

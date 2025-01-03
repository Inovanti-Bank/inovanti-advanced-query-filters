<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;
use InvalidArgumentException;

class RangeFilter implements FilterInterface
{
    public function apply($query, $value)
    {
        $operator = FilterOperatorEnum::from($value['operator']);
        $column = $value['field'];

        return match ($operator) {
            FilterOperatorEnum::BETWEEN => $this->applyBetween($query, $column, $value),
            FilterOperatorEnum::GREATER_THAN_OR_EQUAL => $this->applyGreaterThanOrEqual($query, $column, $value),
            FilterOperatorEnum::LESS_THAN_OR_EQUAL => $this->applyLessThanOrEqual($query, $column, $value),
            default => throw new InvalidArgumentException('Invalid operator for RangeFilter'),
        };
    }

    protected function applyBetween($query, $column, $value)
    {
        if (! isset($value['min'], $value['max'])) {
            throw new InvalidArgumentException("Missing 'min' or 'max' value for 'between' operator");
        }

        return $query->whereBetween($column, [$value['min'], $value['max']]);
    }

    protected function applyGreaterThanOrEqual($query, $column, $value)
    {
        if (! isset($value['min'])) {
            throw new InvalidArgumentException("Missing 'min' value for '>=' operator");
        }

        return $query->where($column, '>=', $value['min']);
    }

    protected function applyLessThanOrEqual($query, $column, $value)
    {
        if (! isset($value['max'])) {
            throw new InvalidArgumentException("Missing 'max' value for '<=' operator");
        }

        return $query->where($column, '<=', $value['max']);
    }
}

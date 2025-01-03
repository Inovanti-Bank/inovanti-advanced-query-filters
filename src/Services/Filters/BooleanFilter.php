<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;
use InvalidArgumentException;

class BooleanFilter implements FilterInterface
{
    public function apply($query, $value)
    {
        $operator = FilterOperatorEnum::from($value['operator']);
        $column = $value['field'];

        if (! isset($value['boolean'])) {
            throw new InvalidArgumentException("Missing 'boolean' value for operator");
        }

        $boolean = $value['boolean'];

        return match ($operator) {
            FilterOperatorEnum::EQUAL => $query->where($column, '=', $boolean),
            FilterOperatorEnum::NOT_EQUAL => $query->where($column, '<>', $boolean),
            default => throw new InvalidArgumentException('Invalid operator for BooleanFilter')
        };
    }
}

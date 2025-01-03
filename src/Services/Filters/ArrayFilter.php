<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;
use InvalidArgumentException;

class ArrayFilter implements FilterInterface
{
    public function apply($query, $value)
    {
        $operator = FilterOperatorEnum::from($value['operator']);
        $column = $value['field'];

        if (! isset($value['array'])) {
            throw new InvalidArgumentException("Missing 'array' value for operator");
        }
        $array = $value['array'];

        return match ($operator) {
            FilterOperatorEnum::IN => $query->whereIn($column, $array),
            FilterOperatorEnum::NOT_IN => $query->whereNotIn($column, $array),
            default => throw new InvalidArgumentException('Invalid operator for ArrayFilter')
        };
    }
}

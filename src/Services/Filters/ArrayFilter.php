<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;

class ArrayFilter implements FilterInterface
{
    public function apply($query, $value)
    {
        $operator = FilterOperatorEnum::from($value['operator']);

        return match ($operator) {
            FilterOperatorEnum::IN => $query->whereIn('field', $value['array']),
            FilterOperatorEnum::NOT_IN => $query->whereNotIn('field', $value['array']),
            default => throw new \InvalidArgumentException('Invalid operator for ArrayFilter')
        };
    }
}

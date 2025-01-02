<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;
use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;

class BooleanFilter implements FilterInterface
{
    public function apply($query, $value)
    {
        $operator = FilterOperatorEnum::from($value['operator']);

        return match($operator)
        {
            FilterOperatorEnum::EQUAL => $query->where('field', (bool) $value['boolean']),
            default => throw new \InvalidArgumentException("Invalid operator for BooleanFilter")
        };
    }
}

<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;

class StringFilter implements FilterInterface
{
    public function apply($query, $value)
    {
        $operator = FilterOperatorEnum::from($value['operator']);

        return match ($operator) {
            FilterOperatorEnum::EQUAL => $query->where('field', '=', $value['string']),
            FilterOperatorEnum::LIKE => $query->where('field', 'like', '%'.$value['string'].'%'),
            FilterOperatorEnum::NOT_LIKE => $query->where('field', 'not like', '%'.$value['string'].'%'),
            default => throw new \InvalidArgumentException('Invalid operator for StringFilter')
        };
    }
}

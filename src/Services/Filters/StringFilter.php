<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;

class StringFilter implements FilterInterface
{
    public function apply($query, $value)
    {
        $operator = FilterOperatorEnum::from($value['operator']);
        $column = $value['field'];

        if (! isset($value['string'])) {
            throw new InvalidArgumentException("Missing 'string' value for operator");
        }

        $string = $value['string'];

        return match ($operator) {
            FilterOperatorEnum::EQUAL => $query->where($column, '=', $string),
            FilterOperatorEnum::LIKE => $query->where($column, 'like', '%'.$string.'%'),
            FilterOperatorEnum::NOT_LIKE => $query->where($column, 'not like', '%'.$string.'%'),
            default => throw new \InvalidArgumentException('Invalid operator for StringFilter')
        };
    }
}

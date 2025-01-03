<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InvalidArgumentException;
use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;

class NullFilter implements FilterInterface
{
    public function apply($query, $value)
    {
        $operator = FilterOperatorEnum::from($value['operator']);
        $column = $value['field'];

        return match ($operator) {
            FilterOperatorEnum::IS_NULL => $query->whereNull($column),
            FilterOperatorEnum::IS_NOT_NULL => $query->whereNotNull($column),
            default => throw new InvalidArgumentException('Invalid operator for NullFilter')
        };
    }
}

<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;
use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;

class RelationFilter implements FilterInterface
{
    public function apply($query, $value)
    {
        $operator = FilterOperatorEnum::from($value['operator']);

        return $query->whereHas('relation', function ($query) use ($value, $operator) {

            return match($operator)
            {
                FilterOperatorEnum::EQUAL => $query->where('related_field', '=', $value['value']),
                FilterOperatorEnum::GREATER_THAN => $query->where('related_field', '>', $value['value']),
                FilterOperatorEnum::LESS_THAN => $query->where('related_field', '<', $value['value']),
                default => throw new \InvalidArgumentException("Invalid operator for RelationFilter")
            };
        });
    }
}

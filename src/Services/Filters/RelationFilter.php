<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InvalidArgumentException;
use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;

class RelationFilter implements FilterInterface
{
    public function apply($query, $value)
    {
        $operator = FilterOperatorEnum::from($value['operator']);
        $relation = $value['relation'];
        $column = $value['field'];
        $relatedColumn = $value['relatedColumn'];

        if (! isset($value['value'])) {
            throw new InvalidArgumentException("Missing 'value' for operator");
        }
        $filterValue = $value['value'];

        return $query->whereHas($relation, function ($q) use ($operator, $relatedColumn, $filterValue) {
            $q->where($relatedColumn, $operator->value, $filterValue);
        });
    }
}

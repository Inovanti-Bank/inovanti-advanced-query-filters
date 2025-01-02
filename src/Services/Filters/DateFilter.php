<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use Carbon\Carbon;
use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;

class DateFilter implements FilterInterface
{
    public function apply($query, $value)
    {
        $operator = FilterOperatorEnum::from($value['operator']);

        if ($operator === FilterOperatorEnum::BETWEEN) {
            if (!isset($value['from']) || !isset($value['to'])) {
                throw new \InvalidArgumentException("Missing 'from' or 'to' value for 'between' operator");
            }
            $carbonDateFrom = Carbon::parse($value['from']);
            $carbonDateTo = Carbon::parse($value['to']);
            return $query->whereBetween('field', [$carbonDateFrom->toDateString(), $carbonDateTo->toDateString()]);
        }

        if (!isset($value['date'])) {
            throw new \InvalidArgumentException("Missing 'date' value for 'equals', 'before' or 'after' operator");
        }
        $carbonDate = Carbon::parse($value['date']);

        return match($operator)
        {
            FilterOperatorEnum::EQUAL => $query->whereDate('field', $carbonDate->toDateString()),
            FilterOperatorEnum::LESS_THAN => $query->whereDate('field', '<', $carbonDate->toDateString()),
            FilterOperatorEnum::GREATER_THAN => $query->whereDate('field', '>', $carbonDate->toDateString()),
            default => throw new \InvalidArgumentException("Invalid operator for DateFilter")
        };
    }
}

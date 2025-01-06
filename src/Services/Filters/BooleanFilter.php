<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;
use InvalidArgumentException;

class BooleanFilter implements FilterInterface
{
    /**
     * Aplica o filtro ao query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($query, $value)
    {
        $this->validateValue($value);

        $operator = FilterOperatorEnum::tryFrom($value['operator']);

        if (! $operator || ! in_array($operator, [
            FilterOperatorEnum::EQUAL,
            FilterOperatorEnum::NOT_EQUAL,
        ])) {
            throw new InvalidArgumentException('Invalid operator for BooleanFilter');
        }

        $column = $value['field'];
        $boolean = filter_var($value['boolean'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        if (is_null($boolean)) {
            throw new InvalidArgumentException("Invalid 'boolean' value for BooleanFilter");
        }

        return match ($operator) {
            FilterOperatorEnum::EQUAL => $query->where($column, '=', $boolean),
            FilterOperatorEnum::NOT_EQUAL => $query->where($column, '<>', $boolean),
        };
    }

    /**
     * Valida os valores fornecidos para o filtro.
     *
     * @throws InvalidArgumentException
     */
    protected function validateValue(array $value): void
    {
        if (! isset($value['field'])) {
            throw new InvalidArgumentException("Missing 'field' value for BooleanFilter");
        }

        if (! isset($value['operator'])) {
            throw new InvalidArgumentException("Missing 'operator' value for BooleanFilter");
        }

        if (! isset($value['boolean'])) {
            throw new InvalidArgumentException("Missing 'boolean' value for BooleanFilter");
        }
    }
}

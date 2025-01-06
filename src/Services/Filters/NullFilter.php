<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;
use InvalidArgumentException;

class NullFilter implements FilterInterface
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
            FilterOperatorEnum::IS_NULL,
            FilterOperatorEnum::IS_NOT_NULL,
        ])) {
            throw new InvalidArgumentException('Invalid operator for NullFilter');
        }

        $column = $value['field'];

        return match ($operator) {
            FilterOperatorEnum::IS_NULL => $query->whereNull($column),
            FilterOperatorEnum::IS_NOT_NULL => $query->whereNotNull($column),
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
            throw new InvalidArgumentException("Missing 'field' value for NullFilter");
        }

        if (! isset($value['operator'])) {
            throw new InvalidArgumentException("Missing 'operator' value for NullFilter");
        }
    }
}

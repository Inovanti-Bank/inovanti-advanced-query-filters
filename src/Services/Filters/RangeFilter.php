<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;
use InvalidArgumentException;

class RangeFilter implements FilterInterface
{
    /**
     * Aplica o filtro de intervalo ao query builder.
     *
     * @param  \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $value  Contém os detalhes do filtro, incluindo operador, campo e valores de intervalo.
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    public function apply($query, $value)
    {
        $operator = FilterOperatorEnum::tryFrom($value['operator']);
        $column = $value['field'];

        if (! in_array($operator, [
            FilterOperatorEnum::BETWEEN,
            FilterOperatorEnum::GREATER_THAN_OR_EQUAL,
            FilterOperatorEnum::LESS_THAN_OR_EQUAL,
        ])) {
            throw new InvalidArgumentException('Invalid operator for RangeFilter');
        }

        return match ($operator) {
            FilterOperatorEnum::BETWEEN => $this->applyBetween($query, $column, $value),
            FilterOperatorEnum::GREATER_THAN_OR_EQUAL => $this->applyComparison($query, $column, '>=', 'min', $value),
            FilterOperatorEnum::LESS_THAN_OR_EQUAL => $this->applyComparison($query, $column, '<=', 'max', $value),
            default => throw new InvalidArgumentException(sprintf("Missing 'min' or 'max' value for 'between' operator on field '%s'", $column)),
        };
    }

    /**
     * Aplica o operador 'between' ao query builder.
     *
     * @param  \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $column  Nome da coluna.
     * @param  array  $value  Contém os valores 'min' e 'max'.
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    protected function applyBetween($query, $column, $value)
    {
        if (! isset($value['min'], $value['max'])) {
            throw new InvalidArgumentException("Missing 'min' or 'max' value for 'between' operator");
        }

        return $query->whereBetween($column, [$value['min'], $value['max']]);
    }

    protected function applyComparison($query, string $column, string $operator, $valueKey, array $value): mixed
    {
        if (! isset($value[$valueKey])) {
            throw new InvalidArgumentException("Missing '{$valueKey}' value for '{$operator}' operator");
        }

        return $query->where($column, $operator, $value[$valueKey]);
    }
}

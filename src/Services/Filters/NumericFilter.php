<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;
use InvalidArgumentException;

class NumericFilter implements FilterInterface
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

        if (! $operator) {
            throw new InvalidArgumentException('Invalid operator for NumericFilter');
        }

        $column = $value['field'];

        return match ($operator) {
            FilterOperatorEnum::EQUAL => $query->where($column, '=', $value['number']),
            FilterOperatorEnum::GREATER_THAN => $query->where($column, '>', $value['number']),
            FilterOperatorEnum::LESS_THAN => $query->where($column, '<', $value['number']),
            FilterOperatorEnum::BETWEEN => $this->applyBetween($query, $column, $value),
            FilterOperatorEnum::IN => $query->whereIn($column, $value['array']),
            FilterOperatorEnum::NOT_IN => $query->whereNotIn($column, $value['array']),
            FilterOperatorEnum::IS_NULL => $query->whereNull($column),
            FilterOperatorEnum::IS_NOT_NULL => $query->whereNotNull($column),
            default => throw new InvalidArgumentException('Unsupported operator for NumericFilter'),
        };
    }

    /**
     * Aplica a lógica para o operador "between".
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     *
     * @throws InvalidArgumentException
     */
    protected function applyBetween($query, string $column, array $value)
    {
        if (! isset($value['min']) || ! isset($value['max'])) {
            throw new InvalidArgumentException("Missing 'min' or 'max' value for 'between' operator");
        }

        return $query->whereBetween($column, [$value['min'], $value['max']]);
    }

    /**
     * Valida os valores fornecidos para o filtro.
     *
     * @throws InvalidArgumentException
     */
    protected function validateValue(array $value): void
    {
        if (! isset($value['field'])) {
            throw new InvalidArgumentException("Missing 'field' value for NumericFilter");
        }

        if (! isset($value['operator'])) {
            throw new InvalidArgumentException("Missing 'operator' value for NumericFilter");
        }

        if ($value['operator'] === FilterOperatorEnum::BETWEEN->value && (! isset($value['min']) || ! isset($value['max']))) {
            throw new InvalidArgumentException("Missing 'min' or 'max' value for 'between' operator");
        }

        if (! isset($value['number']) && ! in_array($value['operator'], [
            FilterOperatorEnum::BETWEEN->value,
            FilterOperatorEnum::IN->value,
            FilterOperatorEnum::NOT_IN->value,
            FilterOperatorEnum::IS_NULL->value,
            FilterOperatorEnum::IS_NOT_NULL->value,
        ], true)) {
            throw new InvalidArgumentException("Missing 'number' value for operator");
        }
    }
}

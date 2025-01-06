<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;
use InvalidArgumentException;

class StringFilter implements FilterInterface
{
    /**
     * Aplica o filtro baseado em strings ao query builder.
     *
     * @param  \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $value  Contém os detalhes do filtro, incluindo operador, campo e valor da string.
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function apply($query, $value)
    {
        $this->validateValue($value);

        $operator = FilterOperatorEnum::tryFrom($value['operator']);
        $column = $value['field'];

        if (! $operator) {
            throw new InvalidArgumentException('Invalid operator for StringFilter');
        }

        return match ($operator) {
            FilterOperatorEnum::EQUAL => $query->where($column, '=', $value['string']),
            FilterOperatorEnum::LIKE => $query->where($column, 'like', '%'.$value['string'].'%'),
            FilterOperatorEnum::NOT_LIKE => $query->where($column, 'not like', '%'.$value['string'].'%'),
            FilterOperatorEnum::IN => $query->whereIn($column, $value['array']),
            FilterOperatorEnum::NOT_IN => $query->whereNotIn($column, $value['array']),
            FilterOperatorEnum::IS_NULL => $query->whereNull($column),
            FilterOperatorEnum::IS_NOT_NULL => $query->whereNotNull($column),
            default => throw new InvalidArgumentException('Unsupported operator for StringFilter'),
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
            throw new InvalidArgumentException("Missing 'field' value for StringFilter");
        }

        if (! isset($value['operator'])) {
            throw new InvalidArgumentException("Missing 'operator' value for StringFilter");
        }

        if (in_array($value['operator'], [
            FilterOperatorEnum::IN->value,
            FilterOperatorEnum::NOT_IN->value,
        ], true) && ! isset($value['array'])) {
            throw new InvalidArgumentException("Missing 'array' value for operator '{$value['operator']}' in StringFilter");
        }

        if (in_array($value['operator'], [
            FilterOperatorEnum::EQUAL->value,
            FilterOperatorEnum::LIKE->value,
            FilterOperatorEnum::NOT_LIKE->value,
        ], true) && ! isset($value['string'])) {
            throw new InvalidArgumentException("Missing 'string' value for operator '{$value['operator']}' in StringFilter");
        }
    }
}

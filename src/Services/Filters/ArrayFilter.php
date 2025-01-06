<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;
use InvalidArgumentException;

class ArrayFilter implements FilterInterface
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
            FilterOperatorEnum::IN,
            FilterOperatorEnum::NOT_IN,
        ])) {
            throw new InvalidArgumentException('Invalid operator for ArrayFilter');
        }

        $column = $value['field'];
        $array = $value['array'];

        return match ($operator) {
            FilterOperatorEnum::IN => $query->whereIn($column, $array),
            FilterOperatorEnum::NOT_IN => $query->whereNotIn($column, $array),
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
            throw new InvalidArgumentException("Missing 'field' value for ArrayFilter");
        }

        if (! isset($value['operator'])) {
            throw new InvalidArgumentException("Missing 'operator' value for ArrayFilter");
        }

        if (! isset($value['array']) || ! is_array($value['array'])) {
            throw new InvalidArgumentException("Missing or invalid 'array' value for ArrayFilter");
        }
    }
}

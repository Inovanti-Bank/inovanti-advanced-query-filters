<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;
use InvalidArgumentException;

class RelationFilter implements FilterInterface
{
    /**
     * Aplica o filtro em uma relação do Eloquent.
     *
     * @param  \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $value  Contém os detalhes do filtro, incluindo operador, relação, campo relacionado e valor.
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function apply($query, $value)
    {
        $this->validateValue($value);

        $operator = FilterOperatorEnum::tryFrom($value['operator']);

        if (!$operator && !isset($value['custom_operator'])) {
            throw new InvalidArgumentException('Invalid operator for RelationFilter');
        }

        $relation = $value['relation'];
        $relatedColumn = $value['relatedColumn'];
        $filterValue = $value['value'];
        $operatorValue = $operator?->value ?? $value['custom_operator'];

        return $query->whereHas($relation, function ($q) use ($operatorValue, $relatedColumn, $filterValue) {
            match ($operatorValue) {
                FilterOperatorEnum::IN => $q->whereIn($relatedColumn, $filterValue),
                FilterOperatorEnum::BETWEEN => $q->whereBetween($relatedColumn, $filterValue),
                default => $q->where($relatedColumn, $operatorValue, $filterValue),
            };
        });
    }

    /**
     * Valida os valores fornecidos para o filtro.
     *
     * @throws InvalidArgumentException
     */
    protected function validateValue(array $value): void
    {
        if (! isset($value['relation'])) {
            throw new InvalidArgumentException("Missing 'relation' value for RelationFilter");
        }

        if (! isset($value['relatedColumn'])) {
            throw new InvalidArgumentException("Missing 'relatedColumn' value for RelationFilter");
        }

        if (! isset($value['operator'])) {
            throw new InvalidArgumentException("Missing 'operator' value for RelationFilter");
        }

        if (! isset($value['value'])) {
            throw new InvalidArgumentException("Missing 'value' for RelationFilter");
        }
    }
}

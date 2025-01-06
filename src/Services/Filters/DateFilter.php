<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Filters;

use Carbon\Carbon;
use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;
use InvalidArgumentException;

class DateFilter implements FilterInterface
{
    /**
     * Aplica o filtro de data ao query builder.
     *
     * @param  \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $value  Contém os detalhes do filtro, incluindo operador, campo e valores de data.
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    public function apply($query, $value)
    {
        $this->validateValue($value);

        $operator = FilterOperatorEnum::tryFrom($value['operator']);

        if (! $operator) {
            throw new InvalidArgumentException('Invalid operator for DateFilter');
        }

        $column = $value['field'];

        return match ($operator) {
            FilterOperatorEnum::EQUAL => $this->applyEqual($query, $column, $value['date']),
            FilterOperatorEnum::LESS_THAN => $this->applyLessThan($query, $column, $value['date']),
            FilterOperatorEnum::GREATER_THAN => $this->applyGreaterThan($query, $column, $value['date']),
            FilterOperatorEnum::BETWEEN => $this->applyBetween($query, $column, $value),
            FilterOperatorEnum::IS_NULL => $query->whereNull($column),
            FilterOperatorEnum::IS_NOT_NULL => $query->whereNotNull($column),
            default => throw new InvalidArgumentException('Unsupported operator for DateFilter'),
        };
    }

    /**
     * Aplica a lógica para o operador "=".
     */
    protected function applyEqual($query, string $column, string $date)
    {
        return $query->whereDate($column, Carbon::parse($date)->toDateString());
    }

    /**
     * Aplica a lógica para o operador "<".
     */
    protected function applyLessThan($query, string $column, string $date)
    {
        return $query->whereDate($column, '<', Carbon::parse($date)->toDateString());
    }

    /**
     * Aplica a lógica para o operador ">".
     */
    protected function applyGreaterThan($query, string $column, string $date)
    {
        return $query->whereDate($column, '>', Carbon::parse($date)->toDateString());
    }

    /**
     * Aplica a lógica para o operador "between".
     */
    protected function applyBetween($query, string $column, array $value)
    {
        if (! isset($value['from']) || ! isset($value['to'])) {
            throw new InvalidArgumentException("Missing 'from' or 'to' value for 'between' operator");
        }

        return $query->whereBetween($column, [
            Carbon::parse($value['from'])->toDateString(),
            Carbon::parse($value['to'])->toDateString(),
        ]);
    }

    /**
     * Valida os valores fornecidos para o filtro.
     *
     * @throws InvalidArgumentException
     */
    protected function validateValue(array $value): void
    {
        if (! isset($value['field'])) {
            throw new InvalidArgumentException("Missing 'field' value for DateFilter");
        }

        if (! isset($value['operator'])) {
            throw new InvalidArgumentException("Missing 'operator' value for DateFilter");
        }

        if ($value['operator'] === FilterOperatorEnum::BETWEEN->value && (! isset($value['from']) || ! isset($value['to']))) {
            throw new InvalidArgumentException("Missing 'from' or 'to' value for 'between' operator");
        }

        if (! isset($value['date']) && ! in_array($value['operator'], [
            FilterOperatorEnum::BETWEEN->value,
            FilterOperatorEnum::IS_NULL->value,
            FilterOperatorEnum::IS_NOT_NULL->value,
        ], true)) {
            throw new InvalidArgumentException("Missing 'date' value for operator");
        }
    }
}

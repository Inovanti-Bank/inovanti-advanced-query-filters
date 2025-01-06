<?php

namespace InovantiBank\AdvancedQueryFilters\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use InovantiBank\AdvancedQueryFilters\Enums\FilterOperatorEnum;
use InovantiBank\AdvancedQueryFilters\Exceptions\InvalidFilterQueryException;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;
use InvalidArgumentException;

class FilterService
{
    protected array $filters;

    protected array $appliedFilters = [];

    /**
     * Construtor do serviço de filtros.
     *
     * @param  array  $filters  Filtros registrados.
     */
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Aplica os filtros ao query builder.
     *
     * @throws InvalidFilterQueryException
     */
    public function applyFilters(Builder $query, array $filters): Builder
    {
        foreach ($filters as $field => $value) {
            if ($this->isFilterRegistered($field)) {
                $this->applyFilter($query, $field, $value);
            } else {
                $this->throwInvalidFilterException($field);
            }
        }

        return $query;
    }

    /**
     * Retorna os filtros aplicados.
     */
    public function getAppliedFilters(): array
    {
        return $this->appliedFilters;
    }

    /**
     * Registra um novo filtro.
     */
    public function registerFilter(string $name, string $filterClass): void
    {
        $this->filters[$name] = $filterClass;
    }

    /**
     * Retorna os filtros registrados.
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * Obtém as traduções dos operadores de filtro.
     */
    public function getFilterOperatorsTranslations(?array $operators = null): array
    {
        return FilterOperatorEnum::getTranslations($operators);
    }

    /**
     * Aplica um filtro específico ao query builder.
     */
    protected function applyFilter(Builder $query, string $field, array $value): void
    {
        /** @var FilterInterface $filterInstance */
        $filterInstance = $this->instantiateFilter($this->filters[$field]);
        $filterInstance->apply($query, $value);
        $this->logAppliedFilter($field, $value);
    }

    /**
     * Verifica se um filtro está registrado.
     */
    protected function isFilterRegistered(string $field): bool
    {
        return isset($this->filters[$field]);
    }

    /**
     * Lança uma exceção para filtros inválidos.
     *
     * @throws InvalidFilterQueryException
     */
    protected function throwInvalidFilterException(string $field): void
    {
        throw new InvalidFilterQueryException(
            new Collection([$field]),
            new Collection(array_keys($this->filters))
        );
    }

    /**
     * Instancia um filtro com base na classe registrada.
     */
    protected function instantiateFilter(string $filterClass): FilterInterface
    {
        if (! is_subclass_of($filterClass, FilterInterface::class)) {
            throw new InvalidArgumentException("The filter class '{$filterClass}' must implement FilterInterface.");
        }

        return new $filterClass;
    }

    /**
     * Registra o filtro aplicado para fins de auditoria ou depuração.
     */
    protected function logAppliedFilter(string $field, array $value): void
    {
        $this->appliedFilters[] = [
            'field' => $field,
            'operator' => $value['operator'] ?? null,
            'value' => $value,
        ];
    }
}

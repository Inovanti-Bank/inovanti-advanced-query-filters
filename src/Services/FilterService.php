<?php

namespace InovantiBank\AdvancedQueryFilters\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use InovantiBank\AdvancedQueryFilters\Exceptions\InvalidFilterQueryException;
use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;

class FilterService
{
    protected array $filters;

    protected array $appliedFilters = [];

    /**
     * FilterService constructor.
     */
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Apply filters to the query.
     *
     * @throws InvalidFilterQueryException
     */
    public function applyFilters(Builder $query, array $filters): Builder
    {
        foreach ($filters as $field => $value) {
            if (isset($this->filters[$field])) {
                /** @var FilterInterface $filterInstance */
                $filterInstance = new $this->filters[$field];
                $query = $filterInstance->apply($query, $value);
                $this->appliedFilters[] = [
                    'field' => $field,
                    'operator' => $value['operator'],
                    'value' => $value,
                ];
            } else {
                throw new InvalidFilterQueryException(
                    new Collection([$field]),
                    new Collection(array_keys($this->filters))
                );
            }
        }

        return $query;
    }

    /**
     * Get the applied filters.
     */
    public function getAppliedFilters(): array
    {
        return $this->appliedFilters;
    }

    /**
     * Register a filter.
     */
    public function registerFilter(string $name, string $filterClass): void
    {
        $this->filters[$name] = $filterClass;
    }

    /**
     * Get the registered filters.
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getFilterOperatorsTranslations(?array $operators = null): array
    {
        return FilterOperatorEnum::getTranslations($operators);
    }
}

<?php

namespace InovantiBank\AdvancedQueryFilters\Services;

use InovantiBank\AdvancedQueryFilters\Services\Interfaces\FilterInterface;
use InovantiBank\AdvancedQueryFilters\Exceptions\InvalidFilterQueryException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class FilterService
{
    protected array $filters;
    protected array $appliedFilters = [];

    /**
     * FilterService constructor.
     *
     * @param array $filters
     */
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Apply filters to the query.
     *
     * @param Builder $query
     * @param array $filters
     * @return Builder
     * @throws InvalidFilterQueryException
     */
    public function applyFilters(Builder $query, array $filters): Builder
    {
        foreach ($filters as $field => $value) {
            if (isset($this->filters[$field])) {
                /** @var FilterInterface $filterInstance */
                $filterInstance = new $this->filters[$field]();
                $query = $filterInstance->apply($query, $value);
                $this->appliedFilters[] = [
                    'field' => $field,
                    'operator' => $value['operator'],
                    'value' => $value
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
     *
     * @return array
     */
    public function getAppliedFilters(): array
    {
        return $this->appliedFilters;
    }

    /**
     * Register a filter.
     *
     * @param string $name
     * @param string $filterClass
     * @return void
     */
    public function registerFilter(string $name, string $filterClass): void
    {
        $this->filters[$name] = $filterClass;
    }

    /**
     * Get the registered filters.
     *
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }
}

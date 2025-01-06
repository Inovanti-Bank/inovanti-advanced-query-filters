<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Traits;

trait FilterableTrait
{
    /**
     * Aplica filtros ao query builder com base em métodos definidos.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, array $filters)
    {
        foreach ($filters as $filter => $value) {
            $method = 'filter'.ucfirst($filter);

            if (method_exists($this, $method)) {
                $query = $this->$method($query, $value);
            } else {
                $this->applyGenericFilter($query, $filter, $value);
            }
        }

        return $query;
    }

    /**
     * Aplica um filtro genérico ao query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     */
    protected function applyGenericFilter($query, string $filter, $value): void
    {
        if (is_array($value) && isset($value['operator'], $value['value'])) {
            $query->where($filter, $value['operator'], $value['value']);
        } else {
            $query->where($filter, '=', $value);
        }
    }
}

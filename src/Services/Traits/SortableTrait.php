<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Traits;

use InvalidArgumentException;

trait SortableTrait
{
    /**
     * Aplica ordenação ao query builder com base nos parâmetros fornecidos.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array|string  $sort
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSort($query, $sort)
    {
        if (is_array($sort)) {
            foreach ($sort as $field => $direction) {
                $query->orderBy($field, $this->validateSortDirection($direction));
            }
        } elseif (is_string($sort)) {
            $parts = explode(',', $sort);
            foreach ($parts as $part) {
                $direction = 'asc';
                if (strpos($part, '-') === 0) {
                    $direction = 'desc';
                    $part = substr($part, 1);
                }
                $query->orderBy($part, $direction);
            }
        }

        return $query;
    }

    /**
     * Valida a direção de ordenação.
     */
    protected function validateSortDirection(string $direction): string
    {
        $validDirections = ['asc', 'desc'];

        if (! in_array(strtolower($direction), $validDirections, true)) {
            throw new InvalidArgumentException("Invalid sort direction: {$direction}. Allowed values are 'asc' or 'desc'.");
        }

        return strtolower($direction);
    }
}

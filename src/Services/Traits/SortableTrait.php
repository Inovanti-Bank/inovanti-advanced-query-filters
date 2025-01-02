<?php

namespace Inovanti\AdvancedQueryFilters\Services\Traits;

trait SortableTrait
{
    /**
     * Apply sorting to the query based on the sort parameters.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array|string $sort
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSort($query, $sort)
    {
        if (is_array($sort)) {
            foreach ($sort as $field => $direction) {
                $query->orderBy($field, $direction);
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
}

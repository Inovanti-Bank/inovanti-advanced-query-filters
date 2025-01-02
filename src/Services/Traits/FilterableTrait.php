<?php

namespace Inovanti\AdvancedQueryFilters\Services\Traits;

trait FilterableTrait
{
    public function scopeFilter($query, array $filters)
    {
        foreach ($filters as $filter => $value) {
            $method = 'filter' . ucfirst($filter);
            if (method_exists($this, $method)) {
                $query = $this->$method($query, $value);
            }
        }

        return $query;
    }
}

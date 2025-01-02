<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Interfaces;

interface Filterable
{
    public function scopeFilter($query, array $filters);
}

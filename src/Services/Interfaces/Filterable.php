<?php

namespace Inovanti\AdvancedQueryFilters\Services\Interfaces;

interface Filterable
{
    public function scopeFilter($query, array $filters);
}

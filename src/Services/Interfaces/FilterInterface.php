<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Interfaces;

interface FilterInterface
{
    public function apply($query, $value);
}

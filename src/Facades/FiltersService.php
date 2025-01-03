<?php

namespace InovantiBank\AdvancedQueryFilters\Facades;

use Illuminate\Support\Facades\Facade;

class FiltersService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filterservice';
    }
}

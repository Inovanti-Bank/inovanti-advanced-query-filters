<?php

namespace InovantiBank\AdvancedQueryFilters\Facades;

use Illuminate\Support\Facades\Facade;

class FilterService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filterservice';
    }
}

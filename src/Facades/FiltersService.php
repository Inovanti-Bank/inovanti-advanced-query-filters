<?php

namespace InovantiBank\AdvancedQueryFilters\Facades;

use Illuminate\Support\Facades\Facade;

class FiltersService extends Facade
{
    /**
     * Obtem o nome do serviço registrado no contêiner.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'filterservice';
    }
}

<?php

namespace InovantiBank\AdvancedQueryFilters\Services\Interfaces;

/**
 * Interface para classes de filtros.
 * Define o contrato para aplicar filtros em consultas.
 */
interface FilterInterface
{
    public function apply($query, $value);
}

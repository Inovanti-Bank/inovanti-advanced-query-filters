<?php

namespace InovantiBank\AdvancedQueryFilters\Enums;

enum SortDirectionEnum: string
{
    case ASCENDING = 'asc';
    case DESCENDING = 'desc';

    /**
     * Verifica se uma direção é válida.
     */
    public static function isValid(string $direction): bool
    {
        return in_array(strtolower($direction), array_column(self::cases(), 'value'), true);
    }

    /**
     * Retorna as direções disponíveis.
     */
    public static function availableDirections(): array
    {
        return array_column(self::cases(), 'value');
    }
}

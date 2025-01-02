<?php

namespace InovantiBank\AdvancedQueryFilters\Enums;

enum FilterOperatorEnum: string
{
    case DYNAMIC = '';
    case EQUAL = '=';
    case LESS_THAN = '<';
    case GREATER_THAN = '>';
    case LESS_THAN_OR_EQUAL = '<=';
    case GREATER_THAN_OR_EQUAL = '>=';
    case NOT_EQUAL = '<>';
    case LIKE = 'like';
    case NOT_LIKE = 'not like';
    case IN = 'in';
    case NOT_IN = 'not in';
    case BETWEEN = 'between';

    /**
     * Retorna o operador traduzido.
     */
    public function getTranslation(): string
    {
        return match ($this) {
            self::DYNAMIC => 'Dinâmico',
            self::EQUAL => '=',
            self::LESS_THAN => '<',
            self::GREATER_THAN => '>',
            self::LESS_THAN_OR_EQUAL => '<=',
            self::GREATER_THAN_OR_EQUAL => '>=',
            self::NOT_EQUAL => '<>',
            self::LIKE => 'Contém',
            self::NOT_LIKE => 'Não contém',
            self::IN => 'Dentro de',
            self::NOT_IN => 'Fora de',
            self::BETWEEN => 'Entre',
        };
    }

    /**
     * Retorna a lista de traduções para os operadores disponíveis.
     */
    public static function getTranslations(array $operators = null): array
    {
        $operatorsToTranslate = $operators ?? self::cases();

        return array_map(
            fn (self $operator) => [
                'operator' => $operator->value,
                'translation' => $operator->getTranslation(),
            ],
            $operatorsToTranslate
        );
    }
}

<?php

namespace InovantiBank\AdvancedQueryFilters\Exceptions;

use InvalidArgumentException;

class InvalidFilterValueException extends InvalidArgumentException
{
    public static function invalidValue(mixed $value, string $field, string $operator): self
    {
        $valueType = gettype($value);
        $message = "O valor `{$value}` (tipo: {$valueType}) não é válido para o campo `{$field}` com o operador `{$operator}`.";
        return new self($message);
    }
}

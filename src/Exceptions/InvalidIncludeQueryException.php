<?php

namespace InovantiBank\AdvancedQueryFilters\Exceptions;

use InovantiBank\AdvancedQueryFilters\Exceptions\InvalidQueryException;

class InvalidIncludeQueryException extends InvalidQueryException
{
    public static function includesNotAllowed(array $invalidIncludes, array $allowedIncludes): self
    {
        $invalid = implode(', ', $invalidIncludes);
        $allowed = implode(', ', $allowedIncludes);

        $message = "As inclusões `{$invalid}` não são permitidas. Inclusões permitidas: `{$allowed}`.";
        return new self($message);
    }
}

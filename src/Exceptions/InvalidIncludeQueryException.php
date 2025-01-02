<?php

namespace Inovanti\AdvancedQueryFilters\Exceptions;

use Inovanti\AdvancedQueryFilters\Exceptions\InvalidQueryException;

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

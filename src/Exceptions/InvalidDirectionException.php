<?php

namespace Inovanti\AdvancedQueryFilters\Exceptions;

use App\Enums\SortDirection;

class InvalidDirectionException extends InvalidQueryException
{
    public static function make(string $direction): self
    {
        $message = sprintf(
            "The direction should be either '%s' or '%s'. '%s' given.",
            SortDirection::ASCENDING->value,
            SortDirection::DESCENDING->value,
            $direction
        );
        return new self($message);
    }
}

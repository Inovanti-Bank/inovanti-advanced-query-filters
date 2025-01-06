<?php

namespace InovantiBank\AdvancedQueryFilters\Exceptions;

use InovantiBank\AdvancedQueryFilters\Enums\SortDirectionEnum;

class InvalidDirectionException extends InvalidQueryException
{
    public static function make(string $direction): self
    {
        $message = sprintf(
            "The direction should be either '%s' or '%s'. '%s' given.",
            SortDirectionEnum::ASCENDING->value,
            SortDirectionEnum::DESCENDING->value,
            $direction
        );

        return new self($message);
    }
}

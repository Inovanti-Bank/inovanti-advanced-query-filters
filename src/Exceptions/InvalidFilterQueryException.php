<?php

namespace InovantiBank\AdvancedQueryFilters\Exceptions;

use Illuminate\Support\Collection;

class InvalidFilterQueryException extends InvalidQueryException
{
    public function __construct(Collection $unknownFilters, Collection $allowedFilters)
    {
        $message = sprintf(
            'Requested filter(s) [%s] are not allowed. Allowed filter(s) are [%s].',
            $unknownFilters->implode(', '),
            $allowedFilters->implode(', ')
        );
        parent::__construct($message);
    }
}

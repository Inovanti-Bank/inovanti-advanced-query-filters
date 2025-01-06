<?php

namespace InovantiBank\AdvancedQueryFilters\Exceptions;

use Illuminate\Support\Collection;

/**
 * @method __construct(Collection $unknownSorts, Collection $allowedSorts)
 */
class InvalidSortQueryException extends InvalidQueryException
{
    public function __construct(Collection $unknownSorts, Collection $allowedSorts)
    {
        $message = sprintf(
            'Requested sort(s) [%s] is not allowed. Allowed sort(s) are [%s].',
            $unknownSorts->implode(', '),
            $allowedSorts->implode(', ')
        );
        parent::__construct($message);
    }
}

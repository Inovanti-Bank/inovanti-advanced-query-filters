<?php

namespace InovantiBank\AdvancedQueryFilters\Exceptions;

use Illuminate\Support\Collection;

/**
 * @method __construct(Collection $appendsNotAllowed, Collection $allowedAppends)
 */
class InvalidAppendQueryException extends InvalidQueryException
{
    public function __construct(Collection $appendsNotAllowed, Collection $allowedAppends)
    {
        $message = sprintf(
            'Requested append(s) [%s] are not allowed. Allowed append(s) are [%s].',
            $appendsNotAllowed->implode(', '),
            $allowedAppends->implode(', ')
        );
        parent::__construct($message);
    }
}

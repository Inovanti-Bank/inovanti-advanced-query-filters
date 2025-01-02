<?php

namespace Inovanti\AdvancedQueryFilters\Exceptions;

use Illuminate\Support\Collection;

/**
 * @method __construct(Collection $unknownFields, Collection $allowedFields)
 */
class InvalidFieldQueryException extends InvalidQueryException
{
    public function __construct(Collection $unknownFields, Collection $allowedFields)
    {
        $message = sprintf(
            "Requested field(s) [%s] are not allowed. Allowed field(s) are [%s].",
            $unknownFields->implode(', '),
            $allowedFields->implode(', ')
        );
        parent::__construct($message);
    }
}

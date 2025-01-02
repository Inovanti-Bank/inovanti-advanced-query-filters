<?php

namespace Inovanti\AdvancedQueryFilters\Exceptions;

use Illuminate\Support\Collection;

class UnknownIncludedFieldsQueryException extends InvalidQueryException
{
    public function __construct(Collection $unknownFields)
    {
        $message = sprintf(
            "Requested field(s) [%s] are not allowed. Please ensure 'allowedFields' is called before 'allowedIncludes'.",
            $unknownFields->implode(', ')
        );
        parent::__construct($message);
    }
}

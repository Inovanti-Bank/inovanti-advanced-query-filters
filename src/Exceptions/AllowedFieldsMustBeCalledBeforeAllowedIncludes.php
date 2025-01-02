<?php

namespace Inovanti\AdvancedQueryFilters\Exceptions;

class AllowedFieldsMustBeCalledBeforeAllowedIncludes extends InvalidQueryException
{
    public function __construct()
    {
        parent::__construct("The 'allowedFields' method must be called before 'allowedIncludes'.");
    }
}

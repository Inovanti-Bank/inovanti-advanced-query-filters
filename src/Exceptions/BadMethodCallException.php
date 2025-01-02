<?php

namespace Inovanti\AdvancedQueryFilters\Exceptions;

use BadMethodCallException as BaseException;

class BadMethodCallException extends BaseException
{
    public function __construct(string $methodName, string $className)
    {
        $message = "O método `{$methodName}` não está implementado ou não é válido na classe `{$className}`.";
        parent::__construct($message);
    }
}

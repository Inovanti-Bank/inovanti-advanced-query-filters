<?php

namespace InovantiBank\AdvancedQueryFilters\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class InvalidQueryException extends HttpException
{
    public function __construct(string $message, int $statusCode = 400)
    {
        parent::__construct($statusCode, $message);
    }
}

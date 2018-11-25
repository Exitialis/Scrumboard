<?php

namespace App\Exceptions;

class AuthorizationException extends BaseException
{
    public function __construct(string $message = null)
    {
        parent::__construct($message ? : 'Недостаточно прав для выполнения данного действия', 403, 'Forbidden');
    }
}

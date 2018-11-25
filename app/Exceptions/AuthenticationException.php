<?php

namespace App\Exceptions;

class AuthenticationException extends BaseException
{
    public function __construct(string $message = null)
    {
        parent::__construct($message ? : 'Неверное имя пользователя или пароль.', 401, 'AuthenticationError');
    }
}

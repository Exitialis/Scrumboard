<?php

namespace App\Exceptions;

class AuthenticationException extends BaseException
{
    public $status = 401;

    public function __construct()
    {
        parent::__construct('Неверное имя пользователя или пароль.');
    }
}

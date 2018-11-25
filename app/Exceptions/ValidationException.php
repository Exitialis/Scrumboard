<?php

namespace App\Exceptions;

class ValidationException extends BaseException
{
    /**
     * ValidationException constructor.
     * @param array $details
     */
    public function __construct(array $details = [])
    {
        parent::__construct("The parameters are incorrect", 422, "ValidationError", $details);
    }
}

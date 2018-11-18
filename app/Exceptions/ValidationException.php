<?php

namespace App\Exceptions;

class ValidationException extends ApiException
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

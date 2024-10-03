<?php

namespace App\Model\Exceptions;

use Exception;

class InvalidCountryCodeException extends Exception
{
    public function __construct(string $message = "Invalid country code")
    {
        parent::__construct($message);
    }
}
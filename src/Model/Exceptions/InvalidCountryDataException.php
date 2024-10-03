<?php

namespace App\Model\Exceptions;

use Exception;

class InvalidCountryDataException extends Exception
{
    public function __construct(string $message = "Invalid country data")
    {
        parent::__construct($message);
    }
}

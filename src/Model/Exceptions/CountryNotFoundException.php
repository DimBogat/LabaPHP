<?php

namespace App\Model\Exceptions;

use Exception;

class CountryNotFoundException extends Exception
{
    public function __construct(string $message = "Country not found")
    {
        parent::__construct($message);
    }
}
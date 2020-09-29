<?php

declare(strict_types=1);

namespace AkioSarkiz\Mp3Php\Exceptions;

use Exception;

class NotFoundFile extends Exception
{
    public function __construct($path)
    {
        parent::__construct("path: $path", -1, null);
    }
}
<?php


namespace AkioSarkiz\Mp3Php\Exceptions;

use Exception;

class FileAlreadyExists extends Exception
{
    public function __construct($file = "")
    {
        parent::__construct("file already exists: $file", -1, null);
    }
}
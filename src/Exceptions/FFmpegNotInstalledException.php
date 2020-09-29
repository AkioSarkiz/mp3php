<?php

declare(strict_types=1);

namespace AkioSarkiz\Mp3Php\Exceptions;

use AkioSarkiz\Mp3Php\Lang;
use Exception;

class FFmpegNotInstalledException extends Exception
{
    public function __construct()
    {
        parent::__construct(Lang::get('not_installed_ffmpeg'), -1, null);
    }
}
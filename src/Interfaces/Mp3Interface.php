<?php

declare(strict_types=1);

namespace AkioSarkiz\Mp3Php\Interfaces;

use AkioSarkiz\Mp3Php\Exceptions\FFmpegNotInstalledException;
use AkioSarkiz\Mp3Php\Exceptions\FileAlreadyExists;
use AkioSarkiz\Mp3Php\Exceptions\NotFoundFile;

/**
 * Interface Mp3Interface
 * @package AkioSarkiz\Mp3Php\Interfaces
 */
interface Mp3Interface
{
    /**
     * Mp3Interface constructor.
     * @param string $path - path to mp3 absolute
     * @throws NotFoundFile
     * @throws FFmpegNotInstalledException
     */
    public function __construct(string $path);

    /**
     * Get current path.
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Get size of file.
     *
     * @return int
     */
    public function size(): int;

    /**
     * Check mp3 file is valid or not.
     *
     * @return bool
     */
    public function isValid(): bool;

    /**
     * Get duration of mp3.
     *
     * @return float
     */
    public function getDuration(): float;

    /**
     * Convert music to your kbs.
     *
     * @param string $outputPath
     * @param int $kbs
     * @return void
     */
    public function convert(string $outputPath, int $kbs = 128): void;

    /**
     * Clear metadata.
     *
     * @param string $outputPath
     * @return void
     * @throws FileAlreadyExists
     */
    public function clearMeta(string $outputPath): void;

    /**
     * Add your meta to mp3.
     *
     * @param array $metas
     * @param string $outputPath
     * @return void
     */
    public function addMeta(array $metas, string $outputPath): void;

    /**
     * Get kbs of mp3.
     *
     * @return float
     */
    public function getKbs(): float;

    /**
     * Get info about mp3.
     *
     * @return array
     */
    public function getInfo(): array;
}
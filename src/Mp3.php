<?php

declare(strict_types=1);

namespace AkioSarkiz\Mp3Php;

use AkioSarkiz\Mp3Php\Exceptions\FFmpegNotInstalledException;
use AkioSarkiz\Mp3Php\Exceptions\FileAlreadyExists;
use AkioSarkiz\Mp3Php\Exceptions\NotFoundFile;
use AkioSarkiz\Mp3Php\Interfaces\Mp3Interface;

/**
 * Class Mp3
 * @package AkioSarkiz\Mp3Php
 */
class Mp3 implements Mp3Interface
{
    protected ?string $path;

    /**
     * @inheritDoc
     */
    public function __construct(string $path)
    {
        if (!file_exists($path)) throw new NotFoundFile($path);
        if (is_null(shell_exec('ffprobe -version'))) throw new FFmpegNotInstalledException();

        $this->path = $path;
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @inheritDoc
     */
    public function size(): int
    {
        return filesize($this->path);
    }

    /**
     * @inheritDoc
     */
    public function isValid(): bool
    {
        $command = "ffprobe -loglevel error -i \"{$this->path}\" 2>&1";
        $errors = shell_exec($command);
        return is_null($errors) || mb_strlen($errors) === 0;
    }

    /**
     * @inheritDoc
     */
    public function getInfo(): array
    {
        $command = "ffprobe -v quiet -print_format json -show_format -show_streams \"{$this->path}\"";
        $json = shell_exec($command);
        return json_decode($json, true);
    }

    /**
     * @inheritDoc
     */
    public function getDuration(): float
    {
        return floatval($this->getInfo()['format']['duration']);
    }

    /**
     * @inheritDoc
     */
    public function clearMeta(string $outputPath): void
    {
        if (file_exists($outputPath)) {
            throw new FileAlreadyExists($outputPath);
        }

        $command = "ffmpeg -n -i \"{$this->path}\" -vn -codec:a copy -map_metadata -1 \"$outputPath\" 2>&1";
        shell_exec($command);
    }

    /**
     * @inheritDoc
     */
    public function convert(string $outputPath, int $kbs = 128): void
    {
        $command = "ffmpeg -i \"{$this->path}\" -b:a {$kbs}k \"{$outputPath}\"";
        shell_exec($command);
    }

    /**
     * @inheritDoc
     */
    public function getKbs(): float
    {
        return floatval($this->getInfo()['streams'][0]['bit_rate']);
    }

    /**
     * @inheritDoc
     */
    public function addMeta(array $metas, string $outputPath): void
    {
        $metadata = '';
        foreach ($metas as $mata_name => $meta_value)
            $metadata .= "-metadata {$mata_name}=\"$meta_value\"";
        $command = "ffmpeg -i \"{$this->path}\" -c copy {$metadata} \"{$outputPath}\"";
        shell_exec($command);
    }
}
<?php

declare(strict_types=1);

namespace Tests;

use AkioSarkiz\Mp3Php\Exceptions\FFmpegNotInstalledException;
use AkioSarkiz\Mp3Php\Exceptions\FileAlreadyExists;
use AkioSarkiz\Mp3Php\Exceptions\NotFoundFile;
use AkioSarkiz\Mp3Php\Lang;
use AkioSarkiz\Mp3Php\Mp3;
use PHPUnit\Framework\TestCase;

class Mp3Test extends TestCase
{
    private bool $tryFix = true;

    /**
     * Reset env variables
     *
     * @return void
     */
    private function finish(): void
    {
        $this->tryFix = true;
    }

    public function testIsValid(): void
    {
        try {
            // testing valid mp3
            $path = realpath(__DIR__ . '/_data/valid') . '/';
            $filenames = scandir($path);
            foreach ($filenames as $filename) {
                if (is_file($path . $filename)) {
                    $mp3item = new Mp3($path . $filename);
                    $this->assertTrue($mp3item->isValid(), "filename: $filename");
                }
            }

            // testing invalid mp3
            $path = realpath(__DIR__ . '/_data/invalid') . '/';
            $filenames = scandir($path);
            foreach ($filenames as $filename) {
                if (is_file($path . $filename)) {
                    $mp3item = new Mp3($path . $filename);
                    $this->assertFalse($mp3item->isValid(), "filename: $filename");
                }
            }
        } catch (NotFoundFile $e) {
            $this->fail(Lang::get('test_not_found_files'));
        } catch (FFmpegNotInstalledException $e) {
            $this->fail(Lang::get('not_installed_ffmpeg'));
        }

        $this->finish();
    }

    public function testGetDuration(): void
    {
        try {
            $info = json_decode(file_get_contents(__DIR__ . '/_data/valid.info.json'), true);
            $path = realpath(__DIR__ . '/_data/valid') . '/';
            $filenames = scandir($path);
            foreach ($filenames as $filename) {
                if (is_file($path . $filename)) {
                    $mp3item = new Mp3($path . $filename);
                    $message = "filename: $filename, json duration: {$info[$filename]['duration']}, method duration: {$mp3item->getDuration()}";
                    $this->assertSame((int)$info[$filename]['duration'], (int)$mp3item->getDuration(), $message);
                }
            }
        } catch (NotFoundFile $e) {
            $this->fail(Lang::get('test_not_found_files'));
        } catch (FFmpegNotInstalledException $e) {
            $this->fail(Lang::get('not_installed_ffmpeg'));
        }

        $this->finish();
    }

    public function testClearMeta(): void
    {
        try {
            $path = realpath(__DIR__ . '/_data/valid') . '/';
            $filenames = scandir($path);
            foreach ($filenames as $filename) {
                if (is_file($path . $filename)) {
                    $mp3item = new Mp3($path . $filename);
                    $outputPath = __DIR__ . "/_data/cleared/$filename";
                    $mp3item->clearMeta($outputPath);
                    $this->assertTrue(file_exists($outputPath));
                }
            }
        } catch (FileAlreadyExists $e) {
            if ($this->tryFix === false) {
                $this->fail(Lang::get('folder_fill_error'));
            }

            // clear files if exists and try run this test again
            $path = realpath(__DIR__ . '/_data/cleared') . '/';
            $filenames = scandir($path);
            foreach ($filenames as $filename) {
                $filepath = __DIR__ . "/_data/cleared/$filename";
                if (file_exists($filepath) && is_file($filepath)) {
                    unlink( __DIR__ . "/_data/cleared/$filename");
                }
            }
            $this->tryFix = false;
            $this->testClearMeta();
        } catch (NotFoundFile $e) {
            $this->fail(Lang::get('test_not_found_files'));
        } catch (FFmpegNotInstalledException $e) {
            $this->fail(Lang::get('not_installed_ffmpeg'));
        }

        $this->finish();
    }
}
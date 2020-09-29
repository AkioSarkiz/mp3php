<?php


namespace AkioSarkiz\Mp3Php;

/**
 * Class Lang is simple class.
 * @package AkioSarkiz\Mp3Php
 */
class Lang
{
    protected static ?array $cache = null;

    public static function checkInit(): void
    {
        if (self::$cache === null) {
            self::$cache = require __DIR__ . '/data/strings.php';
        }
    }

    /**
     * @param string $item
     * @return string|null
     */
    public static function get(string $item): ?string
    {
        self::checkInit();

        if (array_key_exists($item, self::$cache)) {
            $string = self::$cache[$item];
            return  preg_replace_callback('/:([0-9A-z_\-]+)/', function ($found) {
                return (string) self::get($found[1]);
            }, $string);
        }

        return array_key_exists($item, self::$cache) ? self::$cache[$item] : null;
    }
}
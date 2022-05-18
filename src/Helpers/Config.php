<?php

namespace App\Helpers;

use App\Exceptions\ConfigFileNotFoundException;

class Config
{
    public static function getFileContents(string $filename)
    {
        $filePath = realpath(__DIR__ . "/../Configs/" . $filename . ".php");

        if (!$filePath) {
            throw new ConfigFileNotFoundException();
        }
        $FileContents = require $filePath;
        return ($FileContents);
    }
    public static function get(string $filename, string $key = null)
    {
        $FileContents = self::getFileContents($filename);

        if (is_null($key))
            return $FileContents;

        return $FileContents[$key] ?? null;
    }
}

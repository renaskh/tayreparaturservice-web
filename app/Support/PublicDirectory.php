<?php

namespace App\Support;

class PublicDirectory
{
    public static function resolve(string $basePath): string
    {
        $sibling = dirname($basePath).DIRECTORY_SEPARATOR.'public_html';

        if (is_dir($sibling)) {
            return $sibling;
        }

        return $basePath.DIRECTORY_SEPARATOR.'public';
    }
}

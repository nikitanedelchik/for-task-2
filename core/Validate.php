<?php

namespace app\core;

class Validate
{

    private static array $types = [
        'image/jpg',
        'image/jpeg',
        'image/gif',
        'image/webp',
        'text/plain'
    ];

    public static function checkSize($size)
    {
        if ($size === 0) {
            return 'File size is big';
        } else {
            return true;
        }
    }

    public static function checkType($type)
    {
        if (!in_array($type, self::$types)) {
            return 'File format is not available. File must be image or txt';
        } else {
            return true;
        }
    }
}

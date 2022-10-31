<?php

namespace app\core;

class Request
{
    public static function getPath(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    public static function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public static function isGet(): bool
    {
        return self::getMethod() === 'get';
    }

    public static function isPost(): bool
    {
        return self::getMethod() === 'post';
    }

    public static function getRequestParams(): array
    {
        $body = [];
        if (self::isPost()) {
            foreach ($_FILES as $key => $file) {
                $body[$key] = $file;
            }
        }
        if (self::isGet()) {
        foreach ($_GET as $key => $value) {
            $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        }
        return $body;
    }
}

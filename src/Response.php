<?php

namespace App;

class Response
{
    const HTTP_CODE_REDIRECT        = 302;
    const HTTP_CODE_UNAUTHORIZED    = 401;

    public static function redirect(string $url, int $code, string $text = '', bool $replace = true)
    {
        header("Location: $url", $replace, $code);
        die($text);
    }

    public static function notFound(string $text = '404 Not Found')
    {
        header("HTTP/1.0 404 Not Found");
        die($text);
    }
}

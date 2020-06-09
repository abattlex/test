<?php

namespace App;

class Request
{
    const METHOD_GET    = 'GET';
    const METHOD_POST   = 'POST';

    protected string $method;
    protected array $params;

    public function __construct()
    {
        $this->params = $_REQUEST;
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function get(string $paramName)
    {
        return $this->params[$paramName] ?? null;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function isGET(): bool
    {
        return $this->method === self::METHOD_GET;
    }

    public function isPOST(): bool
    {
        return $this->method === self::METHOD_POST;
    }
}

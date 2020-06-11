<?php

namespace App;

class Request
{
    const METHOD_GET    = 'GET';
    const METHOD_POST   = 'POST';

    protected string $method;
    protected array $params;
    protected ?Session $session;
    protected ?array $uriParams;

    public function __construct()
    {
        $this->params       = $_REQUEST;
        $this->method       = $_SERVER['REQUEST_METHOD'];
        $this->session      = null;
        $this->uriParams    = null;
    }

    public function getUriParams()
    {
        return $this->uriParams;
    }

    public function setUriParams(array $uriParams)
    {
        $this->uriParams = $uriParams;
        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(Session $session): Request
    {
        $this->session = $session;
        return $this;
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

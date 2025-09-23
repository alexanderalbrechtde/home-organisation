<?php

namespace Framework\Requests;

class httpRequests
{
    private array $get;
    private array $post;
    private array $server;
    private array $session;

    private array $routeParameters;

    public function __construct(array $get, array $post, array $server, array &$session)
    {
        $this->get = $get;
        $this->post = $post;
        $this->server = $server;
        $this->session = $session;
    }

    function getRawQuery(): mixed
    {
        return $this->get;
    }

    function getQuery(string $key): mixed
    {
        return $this->get[$key] ?? null;
    }

    function getPayload(): array
    {
        return $this->post;
    }

    function getServer(): array
    {
        return $this->server;
    }

    function getSession(): array
    {
        return $this->session;
    }

    function getPathinfo(): string
    {
        return $this->server['PATH_INFO'] ?? '/';
    }

    function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    function getRequestUri(): string
    {
        return $this->server['REQUEST_URI'] ?? '/';
    }

    public function getRouteParameters(string $key): mixed
    {
        return $this->routeParameters[$key];
    }

    public function setRouteParameters(array $routeParameters): void
    {
        $this->routeParameters = $routeParameters;
    }
}
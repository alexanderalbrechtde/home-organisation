<?php

namespace Framework\Requests;

readonly class httpRequests
{
    private array $get;
    private array $post;
    private array $server;
    private array $session;

    public function __construct(array $get, array $post, array $server, array &$session)
    {
        $this->get =  $get;
        $this->post = $post;
        $this->server = $server;
        $this->session = $session;
    }

    function getQuery(): array
    {
        return $this->get;
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
}



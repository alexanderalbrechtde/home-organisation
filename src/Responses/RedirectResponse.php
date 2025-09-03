<?php

namespace App\Responses;

use App\Interfaces\ResponseInterface;

class RedirectResponse implements ResponseInterface
{
    public function __construct(private string $location)
    {
    }

    public function send(): void
    {
        http_response_code(204);
        header('Location: ' . $this->location);
    }
}
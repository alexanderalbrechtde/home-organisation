<?php

namespace Framework\Responses;

use Framework\Interfaces\ResponseInterface;

class RedirectResponse implements ResponseInterface
{
    public function __construct(private string $location)
    {
    }

    public function send(): void
    {
        //vorübergehend deaktiviert um Fehler beim Login zu beheben
        //http_response_code(204);
        header('Location: ' . $this->location);
    }
}
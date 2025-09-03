<?php

namespace Responses;

use App\Interfaces\ResponseInterface;

class EmptyResponse implements ResponseInterface
{

    public function send(): void
    {
        http_response_code(204);
    }
}
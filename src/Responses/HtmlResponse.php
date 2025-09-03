<?php

namespace App\Responses;

use App\Interfaces\ResponseInterface;

readonly class HtmlResponse implements ResponseInterface
{
    public function __construct(private string $html)
    {
    }
    public function send(): void
    {
        echo $this->html;
    }
}
<?php

namespace Framework\Responses;

use Framework\Interfaces\ResponseInterface;

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
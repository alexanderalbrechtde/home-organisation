<?php

namespace App\Controller;


use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Requests\httpRequests;
use Framework\Responses\HtmlResponse;
use Framework\Services\HtmlRenderer;

class RegisterController implements ControllerInterface
{
    public function __construct(private HtmlRenderer $htmlRenderer)
    {
    }

    function handle(httpRequests $httpRequest): ResponseInterface
    {
        return new HtmlResponse($this->htmlRenderer->render('register.phtml', $httpRequest->getPayload()));
    }
}
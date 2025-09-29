<?php

namespace App\Controller;

use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Requests\httpRequests;
use Framework\Responses\HtmlResponse;
use Framework\Services\HtmlRenderer;

class ErrorController implements ControllerInterface
{
    public function __construct(private HtmlRenderer $htmlRenderer)
    {
    }

    function handle(httpRequests $httpRequest): ResponseInterface
    {
        if (!$httpRequest->getSessionLoggedIn()) {
            header('Location: /login');
            exit;
        }

        return new HtmlResponse($this->htmlRenderer->render('error.phtml', $httpRequest->getPayload()));
    }
}
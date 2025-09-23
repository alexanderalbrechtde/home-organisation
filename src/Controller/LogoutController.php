<?php

namespace App\Controller;


use App\Interfaces\HtmlRespose;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Requests\httpRequests;
use Framework\Responses\HtmlResponse;
use Framework\Services\HtmlRenderer;

class LogoutController implements ControllerInterface
{
    public function __construct(private HtmlRenderer $htmlRenderer)
    {
    }

    function handle(httpRequests $httpRequest): ResponseInterface
    {
        return new HtmlResponse($this->htmlRenderer->render('login.phtml', $httpRequest->getPayload()));
    }
}
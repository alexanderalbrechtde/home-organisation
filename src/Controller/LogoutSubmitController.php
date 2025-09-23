<?php

namespace App\Controller;

use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Requests\httpRequests;
use Framework\Responses\RedirectResponse;

class LogoutSubmitController implements ControllerInterface
{

    function handle(httpRequests $httpRequest): ResponseInterface
    {
        if (!empty($httpRequest->getPayload()['destroySession'])) {
            //noch zu bearbeiten
            $_SESSION = [];
            session_destroy();
            return new RedirectResponse('login');
        }
    }
}
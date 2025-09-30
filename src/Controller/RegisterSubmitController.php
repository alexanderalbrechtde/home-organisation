<?php

namespace App\Controller;

use App\Services\RegisterService;

use App\Services\Utilities;
use App\Validators\RegisterSubmitValidator;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Requests\httpRequests;
use Framework\Responses\HtmlResponse;
use Framework\Responses\RedirectResponse;
use Framework\Services\HtmlRenderer;

class RegisterSubmitController implements ControllerInterface
{

    public function __construct(
        private RegisterService $registerService,
        private RegisterSubmitValidator $payloadValidator,
    ) {
    }

    function handle(httpRequests $httpRequest): ResponseInterface
    {
        $valid = $this->payloadValidator->validate($httpRequest->getPayload());
        if (!$valid) {
            $allErrors = $this->payloadValidator->getMessages();

            foreach ($allErrors as $field => $messages) {
                foreach ($messages as $message) {
                    $_SESSION['flashMessages'][$field][] = $message;
                }
            }

            return new RedirectResponse("/register");
        }

        $isRegisted = $this->registerService->register(
            $httpRequest->getPayload()['fName'],
            $httpRequest->getPayload()['lName'],
            $httpRequest->getPayload()['email'],
            $httpRequest->getPayload()['password'],
            $httpRequest->getPayload()['password2'],
        );

        if (!$isRegisted) {
            return new RedirectResponse('/register?error=register_failed');
        }
        return new RedirectResponse('/login?register=success');
    }
}
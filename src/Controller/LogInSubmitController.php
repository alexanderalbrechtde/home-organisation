<?php

namespace App\Controller;

use App\Services\LoginService;
use App\Validators\LogInSubmitValidator;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Requests\httpRequests;
use Framework\Responses\RedirectResponse;

class LogInSubmitController implements ControllerInterface
{

    public function __construct(
        private LoginService $loginService,
        private LogInSubmitValidator $payloadValidator,
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

            return new RedirectResponse("/login");
        }
        //hier Observer
        $isLoggedin = $this->loginService->login(
            $httpRequest->getPayload()['email'],
            $httpRequest->getPayload()['password']
        );


        if ($isLoggedin) {
            return new RedirectResponse('/');
        }
        return new RedirectResponse('/login');
    }
}
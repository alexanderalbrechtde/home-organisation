<?php
namespace App\Controller;

use App\Services\LoginService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Requests\httpRequests;
use Framework\Responses\RedirectResponse;

class LogInSubmitController implements ControllerInterface
{
    public function __construct(private LoginService $loginService)
    {
    }

    function handle(httpRequests $httpRequest): ResponseInterface
    {
        $isLoggedin = $this->loginService->login($httpRequest->getPayload()['email'], $httpRequest->getPayload()['password']);

        if (!$isLoggedin) {
            return new RedirectResponse('/login?error=login_failed');
        }
        return new RedirectResponse('/');
    }
}
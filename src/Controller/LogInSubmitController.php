<?php
namespace App\Controller;

use App\Services\LoginService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Responses\RedirectResponse;

class LogInSubmitController implements ControllerInterface
{
    public function __construct(private LoginService $loginService)
    {
    }

    function handle($post, $get, $server, &$session): ResponseInterface
    {
        $isLoggedin = $this->loginService->login($post['email'], $post['password']);

        if (!$isLoggedin) {
            return new RedirectResponse('/login?error=login_failed');
        }
        return new RedirectResponse('/');
    }
}
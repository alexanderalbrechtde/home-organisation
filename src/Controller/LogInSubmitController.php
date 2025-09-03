<?php
namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Interfaces\ResponseInterface;
use App\Responses\RedirectResponse;
use App\Services\LoginService;
use App\Responses\HtmlResponse;
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
<?php
namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Services\LoginService;

class LogInSubmitController implements ControllerInterface
{
    public function __construct(private LoginService $loginService)
    {
    }

    function handle($post, $get, $server, &$session): string
    {
        $isLoggedin = $this->loginService->login($post['email'], $post['password']);

        if (!$isLoggedin) {
            header('Location: /login?error=login_failed');
            return '';
        }
        header('Location: /');
        return '';
    }
}
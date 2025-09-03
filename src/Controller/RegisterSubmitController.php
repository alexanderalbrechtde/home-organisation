<?php

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Interfaces\ResponseInterface;
use App\Responses\RedirectResponse;
use App\Services\RegisterService;
use App\Responses\HtmlResponse;class RegisterSubmitController implements ControllerInterface
{
    public function __construct(private RegisterService $registerService)
    {
    }

    function handle($post, $get, $server, &$session): ResponseInterface
    {
        $register = $this->registerService->register(
            $post['fName'],
            $post['lName'],
            $post['email'],
            $post['password'],
            $post['password2']
        );

        if (!$register) {
            return new RedirectResponse('/register?error=register_failed');
        }
        return new RedirectResponse('/login?register=success');
    }
}
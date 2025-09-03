<?php

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Services\RegisterService;

class RegisterSubmitController implements ControllerInterface
{
    public function __construct(private RegisterService $registerService)
    {
    }

    function handle($post, $get, $server, &$session): string
    {
        $register = $this->registerService->register(
            $post['fName'],
            $post['lName'],
            $post['email'],
            $post['password'],
            $post['password2']
        );

        if (!$register) {
            header('location: /register?error=register_failed');
            exit;
        }
        header('location: /login?register=success');
        return '';
    }
}
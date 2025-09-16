<?php

namespace App\Controller;

use App\Services\AccountService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Responses\RedirectResponse;

class AccountSubmitController implements ControllerInterface
{
    public function __construct(private AccountService $accountService)
    {
    }

    function handle($post, $get, $server, &$session): ResponseInterface
    {
        $userId = $session['user_id'] ?? null;
        $email = $post['email'] ?? null;
        $password = $post['password'] ?? null;
        $email = strtolower($email);

        $updated = $this->accountService->setEmail($email, (int)$userId, (string)$password);

        if ($updated) {
            return new RedirectResponse('/account?changed_successfully');
        } else {
            return new RedirectResponse('/account?change_failed');
        }
    }
}
<?php

namespace App\Services;

use Framework\Services\UserService;

class LoginService
{
    public function __construct(private UserService $userService)
    {
    }

    function login(string $email, string $password): bool
    {
        if (empty($email) || empty($password)) {
            return false;
        }

        $user = $this->userService->getUserbyEmail($email);


        if (!$user) {
            return false;
        }
        if ($user->password !== $password) {
            return false;
        }
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->first_name . ' ' . $user->last_name;

        return true;
    }
}
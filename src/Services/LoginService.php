<?php

namespace App\Services;

use App\Observable\LoginObservable;
use Framework\Services\EventManager;
use Framework\Services\UserService;

class LoginService
{
    public function __construct(
        private UserService $userService,
        //private EventManager $eventManager
    ) {
    }

    function login(string $email, string $password): bool
    {
        if (empty($email) || empty($password)) {
            return false;
        }

        $user = $this->userService->getUserByEmail($email);

        if (!$user) {
            return false;
        }

        $userPassword = $user->password;

        if ($userPassword != $password) {
            return false;
        }

        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->firstName . ' ' . $user->lastName;

        //$this->eventManager->notify(new LoginObservable($user->id, $user->email, $password));

        return true;
    }
}
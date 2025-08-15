<?php

class LoginService
{
    function login(string $username, string $email, string $password): bool
    {
        $UserService = new UserService();
        $user = $UserService->getUserbyUsername($username);

        if (!$user) {
            return false;
        }
        if ($user->password !== $password) {
            return false;
        }

        if ($user->email != $email) {
            return false;
        }

        $_SESSION['logged_in'] = true;

        return true;
    }
}
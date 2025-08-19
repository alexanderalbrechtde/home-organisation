<?php

class LoginService
{
    function login(string $email, string $password): bool
    {
        if (empty($email) || empty($password)) {
            return false;
        }

        $UserService = new UserService();
        $user = $UserService->getUserbyEmail($email);


        if (!$user) {
            return false;
        }

        if ($user->password !== $password) {
            return false;
        }

        $_SESSION['logged_in'] = true;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->first_Name . ' ' . $user->last_Name;

        if (!headers_sent()) {
            header('Location: /');
            exit;
        }

        return true;
    }
}
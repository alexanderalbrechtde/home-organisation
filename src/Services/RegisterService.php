<?php

class RegisterService
{
function register(string $first_Name, string $last_Name, string $email, string $pwd, string $pwd2): bool{
    $UserService = new UserService();
    $user = $UserService->getUserbyEmail($email);

    if (!$user) {
        return false;
    }

    if ($pwd === $pwd2) {
        return false;
    }

}
}
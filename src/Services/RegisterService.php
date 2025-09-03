<?php

namespace App\Services;

use PDO;

class RegisterService
{
    public function __construct(private PDO $pdo){

    }
    function register(string $first_Name, string $last_Name, string $email, string $password, string $password2): bool
    {
        // if ($user) {
        //     return false;
        // }

        if (empty($first_Name) || empty($last_Name) || empty($email) || empty($password) || empty($password2)) {
            return false;
        }

        if ($password !== $password2) {
            return false;
        }

        if (strlen($password) < 8) {
            return false;
        }

        $statement = $this->pdo->prepare(
            'INSERT INTO user (first_Name, last_Name, email, password) VALUES (:firstName, :lastName, :email, :password)'
        );

        $statement->execute([
            'firstName' => $first_Name,
            'lastName' => $last_Name,
            'email' => $email,
            'password' => $password,
        ]);

        return true;
    }
}
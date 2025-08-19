<?php

class RegisterService
{
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


        $pdo = new PDO('sqlite:' . __DIR__ . '/../../data/home-organisation.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $pdo->prepare(
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
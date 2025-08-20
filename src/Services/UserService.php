<?php

class UserService
{

    public function getUserbyEmail(string $email): ?UserDto
    {
        $pdo = new PDO('sqlite:' . __DIR__ . '/../../data/home-organisation.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare(
            'SELECT *  FROM user WHERE email = :email LIMIT 1'
        );
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->createUserDto($row);
    }

    private function getUsers(): array
    {
        $pdo = new PDO('sqlite:' . __DIR__ . '/../../data/home-organisation.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->query('SELECT * FROM user');
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    }

    private function createUserDto(array $user): UserDto
    {
        return new UserDto(
            $user['id'],
            $user['first_Name'],
            $user['last_Name'],
            $user['email'],
            $user['password'],
        );
    }

}
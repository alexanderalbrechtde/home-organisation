<?php

namespace App\Services;

use App\Dtos\UserDto;
use PDO;

class UserService
{

    public function __construct(private PDO $pdo){

    }

    public function getUserbyEmail(string $email): ?UserDto
    {

        $stmt = $this->pdo->prepare(
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
        $stmt = $this->pdo->query('SELECT * FROM user');
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
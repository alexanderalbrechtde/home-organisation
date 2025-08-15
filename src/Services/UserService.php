<?php

use Dtos\UserDto;

class UserService
{

    public function getUserbyUsername(string $username): ?UserDto
    {
        $users = $this->getUsers();
        $user = $users[$username];

        return $this->createUserDto($user);
    }

    public function getUserbyEmail(string $email): ?UserDto
    {
        $users = $this->getUsers();

        foreach ($users as $user) {
            if ($user['email'] === $email) {
                return $this->createUserDto($user);
            }
        }

        return null;
    }

    private
    function getUsers(): array
    {
        $path = __DIR__ . '/../../data/users.json';
        $json = file_get_contents($path);
        $users = json_decode($json, true);

        return $users;
    }

    private function createUserDto(array $user): UserDto
    {
        return new UserDto(
            $user['first_Name'],
            $user['last_Name'],
            $user['email'],
            $user['password'],
            $user['username']
        );
    }

}
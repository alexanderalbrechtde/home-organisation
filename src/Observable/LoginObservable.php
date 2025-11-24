<?php

namespace App\Observable;

use Framework\Services\EventManager;

class LoginObservable
{
    public function __construct(public string $userId, public string $email, public string $password)
    {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getUserEmail(): string
    {
        return $this->email;
    }

    public function getUserPassword(): string
    {
        return $this->password;
    }
}
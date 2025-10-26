<?php

namespace App\Entities;

use Framework\Interfaces\EntityInterface;

class UserEntity implements EntityInterface
{
    public function __construct(
        public string $first_Name,
        public string $last_Name,
        public string $email,
        public string $password,
        public int $user_id = 0,
    ) {
    }

    public static function getTable(): string
    {
        return 'user';
    }

    public function getId(): int
    {
        return $this->user_id;
    }

    public function setId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

}
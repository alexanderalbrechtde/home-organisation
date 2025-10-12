<?php

namespace App\Entities;

use Framework\Interfaces\EntityInterface;

class UserEntity implements EntityInterface
{
    public function __construct(
        public ?int $id = null,
        public ?string $first_Name = null,
        public ?string $last_Name = null,
        public ?string $email = null,
        public ?string $password = null
    ) {
    }

    public static function getTable(): string
    {
        return 'user';
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

}
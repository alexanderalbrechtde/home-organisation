<?php

namespace App\Entities;

use Framework\Attributes\OrmColumn;
use Framework\Attributes\OrmFk;
use Framework\Attributes\OrmTable;
use Framework\Interfaces\EntityInterface;

#[OrmTable('user')]
class UserEntity implements EntityInterface
{

    public function __construct(
        public ?int $id = null,
        #[OrmColumn('first_name')]
        public string $firstName,
        #[OrmColumn('last_name')]
        public string $lastName,
        public string $email,
        public string $password,
    ) {
    }

    public static function getTable(): string
    {
        return 'user';
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
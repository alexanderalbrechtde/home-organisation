<?php

namespace App\Entities;

use Framework\Attributes\OrmColumn;
use Framework\Attributes\OrmFk;
use Framework\Attributes\OrmTable;
use Framework\Interfaces\EntityInterface;

#[OrmTable('room')]
class RoomEntity implements EntityInterface
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        #[OrmColumn('user_id')]
        public UserEntity $user,
        #[OrmColumn('created_at')]
        public string $created,
    ) {
    }

    public static function getTable(): string
    {
        return 'room';
    }
}
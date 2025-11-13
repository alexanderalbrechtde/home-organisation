<?php

namespace App\Entities;

use Framework\Attributes\OrmColumn;
use Framework\Attributes\OrmTable;
use Framework\Interfaces\EntityInterface;

#[OrmTable('user_to_task')]
class UserToTaskEntity implements EntityInterface
{
    public function __construct(
        public ?int $id = null,
        #[OrmColumn('owner_id')]
        public ?UserEntity $user = null,
        #[OrmColumn('task_id')]
        public ?TaskEntity $task = null
    ) {
    }

    public static function getTable(): string
    {
        return 'User_to_task';
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
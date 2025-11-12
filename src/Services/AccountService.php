<?php

namespace App\Services;

use App\Entities\UserEntity;
use Framework\Interfaces\EntityInterface;
use Framework\Services\OrmService;
use Framework\Services\UserService;

class AccountService
{

    public function __construct(
        private UserService $userService,
        private OrmService $ormService
    ) {
    }

    public function showParameters(int $userId): EntityInterface
    {
        $userParams = $this->ormService->findOneBy(
            ['id' => $userId],
            UserEntity::class
        );
        return $userParams;
    }

    public function setEmail(
        string $email,
        int $userId,
        string $password
    ): bool {
        $user = $this->userService->getUserbyId($userId);
        if (!isset($user->password) || $user->password !== $password) {
            return false;
        }

        $user->email = $email;
        return $this->ormService->save($user);
    }

}
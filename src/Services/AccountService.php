<?php

namespace App\Services;

use App\Entities\UserEntity;
use Framework\Interfaces\EntityInterface;
use Framework\Services\OrmService;
use Framework\Services\UserService;
use PDO;

class AccountService
{

    public function __construct(
        private UserService $userService,
        private OrmService $ormService
    ) {
    }

    public function showParameters(int $userId): EntityInterface
    {
        //$stmt = $this->pdo->prepare(
        //    'SELECT id, first_Name, last_Name, email
        //            FROM user
        //            WHERE id = :userId'
        //);
        //$stmt->execute(['userId' => $userId]);
        //return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

        $userParams = $this->ormService->findOneBy(
            ['id' => $userId],
            UserEntity::class
        );
            //dd($userParams);

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
<?php

namespace App\Services;

use Framework\Services\OrmService;
use Framework\Services\UserService;
use PDO;

class AccountService
{

    public function __construct(
        private PDO $pdo,
        private UserService $userService,
        private OrmService $ormService
    ) {
    }

    public function showParameters(int $userId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, first_Name, last_Name, email 
                    FROM user 
                    WHERE id = :userId'
        );
        $stmt->execute(['userId' => $userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
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
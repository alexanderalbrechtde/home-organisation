<?php

namespace App\Services;

use App\Entities\UserEntity;
use Framework\Services\OrmService;

class RegisterService
{
    public function __construct(private OrmService $ormService)
    {
    }

    function register(
        //
        string $first_Name,
        string $last_Name,
        string $email,
        string $password,
        string $password2
    ): bool {
        if ($password !== $password2) {
            return false;
        }
        $password = password_hash($password, PASSWORD_DEFAULT);

        $user = new UserEntity(null, $first_Name, $last_Name, $email, $password);

        return $this->ormService->save($user);
    }
}
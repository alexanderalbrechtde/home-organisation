<?php

namespace Framework\Services;

use _PHPStan_1c270d899\Nette\Neon\Exception;
use App\Dtos\UserDto;
use App\Entities\UserEntity;
use Framework\Interfaces\EntityInterface;
use function PHPUnit\Framework\throwException;

class UserService
{

    public function __construct(private OrmService $ormService)
    {
    }

    public function getUserByEmail(string $email): EntityInterface
    {
        $user = $this->ormService->findOneBy(
            [
                'email' => $email
            ],
            UserEntity::class
        );

        $this->validateUser($user);

        return $user;
    }

    //nicht perfekt aber handelt erstmal das Nichtfinden der Mail
    public function validateUser($user): bool
    {
        if(!$user){
           throw new \Exception("Benutzer mit dieser E-Mail wurde nicht gefunden.");
        }
        return true;
    }

    private function createUserDto(array $user): UserDto
    {
        return new UserDto(
            $user['id'],
            $user['first_name'],
            $user['last_name'],
            $user['email'],
            $user['password'],
        );
    }

    public function getUserbyId(int $id): EntityInterface
    {
        $user = $this->ormService->findOneBy(
            [
                'id' => $id
            ],
            UserEntity::class
        );
        return $user;
    }

}
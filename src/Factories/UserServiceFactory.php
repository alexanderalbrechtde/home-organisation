<?php

namespace App\Factories;

use App\Interfaces\FactoryInterface;
use App\Services\ObjectManagerService;
use App\Services\UserService;
use PDO;

class UserServiceFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(): object
    {
        return new UserService($this->objectManagerService->get(PDO::class));
    }
}
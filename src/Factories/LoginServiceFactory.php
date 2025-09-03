<?php

namespace App\Factories;

use App\Interfaces\FactoryInterface;
use App\Services\LoginService;
use App\Services\ObjectManagerService;
use App\Services\UserService;

class LoginServiceFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(): object
    {
        return new LoginService($this->objectManagerService->get(UserService::class));
    }
}
<?php

namespace App\Factories;

use App\Controller\LogInSubmitController;
use App\Interfaces\FactoryInterface;
use App\Services\LoginService;
use App\Services\ObjectManagerService;

class LogInSubmitControllerFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(): object
    {
        return new LogInSubmitController($this->objectManagerService->get(LoginService::class));
    }
}
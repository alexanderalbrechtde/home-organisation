<?php

namespace App\Factories;

use App\Controller\RegisterSubmitController;
use App\Interfaces\FactoryInterface;
use App\Services\ObjectManagerService;
use App\Services\RegisterService;

class RegisterSubmitControllerFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(string $className): object
    {
        return new RegisterSubmitController($this->objectManagerService->get(RegisterService::class));
    }
}
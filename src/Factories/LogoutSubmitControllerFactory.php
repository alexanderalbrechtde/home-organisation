<?php

namespace App\Factories;

use App\Controller\LogoutSubmitController;
use App\Interfaces\FactoryInterface;
use App\Services\ObjectManagerService;

class LogoutSubmitControllerFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(): object
    {
        return new LogoutSubmitController();
    }
}
<?php

namespace App\Factories;

use App\Interfaces\FactoryInterface;
use App\Services\LogoutService;
use App\Services\ObjectManagerService;

class LogoutServiceFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(): object
    {
        return new LogoutService();
    }
}
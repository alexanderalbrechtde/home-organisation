<?php

namespace App\Factories;

use App\Interfaces\FactoryInterface;
use App\Services\ObjectManagerService;
use App\Services\RoomsService;
use PDO;

class RoomsServiceFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(): object
    {
        return new RoomsService($this->objectManagerService->get(PDO::class));
    }
}
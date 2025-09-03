<?php

namespace App\Factories;

use App\Interfaces\FactoryInterface;
use App\Services\ObjectManagerService;
use App\Services\RoomsCreateService;
use PDO;

class RoomsCreateServiceFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(): object
    {
        return new RoomsCreateService($this->objectManagerService->get(PDO::class));
    }
}
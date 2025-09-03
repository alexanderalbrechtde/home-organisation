<?php

namespace App\Factories;

use App\Interfaces\FactoryInterface;
use App\Services\ObjectManagerService;
use App\Services\WarehouseService;
use PDO;

class WarehouseServiceFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(string $className): object
    {
        return new WarehouseService($this->objectManagerService->get(PDO::class));
    }
}
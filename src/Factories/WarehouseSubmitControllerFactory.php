<?php

namespace App\Factories;

use App\Controller\WarehouseSubmitController;
use App\Interfaces\FactoryInterface;
use App\Services\ObjectManagerService;
use App\Services\WarehouseService;

class WarehouseSubmitControllerFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(): object
    {
        return new WarehouseSubmitController(
            $this->objectManagerService->get(WarehouseService::class),
        );
    }
}
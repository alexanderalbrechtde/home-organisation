<?php

namespace App\Factories;

use App\Controller\WarehouseController;
use App\Interfaces\FactoryInterface;
use App\Services\HtmlRenderer;
use App\Services\ObjectManagerService;
use App\Services\WarehouseService;

class WarehouseControllerFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(): object
    {
        return new WarehouseController(
            $this->objectManagerService->get(WarehouseService::class),
            $this->objectManagerService->get(HtmlRenderer::class),
        );
    }
}
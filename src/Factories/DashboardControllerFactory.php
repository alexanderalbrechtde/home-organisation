<?php

namespace App\Factories;

use App\Controller\DashboardController;
use App\Interfaces\FactoryInterface;
use App\Services\DashboardService;
use App\Services\HtmlRenderer;
use App\Services\ObjectManagerService;

class DashboardControllerFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(): object
    {
        return new DashboardController(
            $this->objectManagerService->get(HtmlRenderer::class),
            $this->objectManagerService->get(DashboardService::class)
        );
    }
}
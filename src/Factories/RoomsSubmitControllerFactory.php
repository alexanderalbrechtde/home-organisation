<?php

namespace App\Factories;

use App\Controller\RoomsSubmitController;
use App\Interfaces\FactoryInterface;
use App\Services\HtmlRenderer;
use App\Services\ObjectManagerService;
use App\Services\RoomsCreateService;
use App\Services\RoomsService;

class RoomsSubmitControllerFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(): object
    {
        return new RoomsSubmitController(
            $this->objectManagerService->get(RoomsCreateService::class),
            $this->objectManagerService->get(HtmlRenderer::class),
            $this->objectManagerService->get(RoomsService::class),
        );
    }
}
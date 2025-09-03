<?php

namespace App\Factories;

use App\Controller\RoomController;
use App\Interfaces\FactoryInterface;
use App\Services\HtmlRenderer;
use App\Services\ObjectManagerService;
use App\Services\ReminderService;
use App\Services\RoomsService;

class RoomControllerFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(string $className): object
    {
        return new RoomController(
            $this->objectManagerService->get(RoomsService::class),
            $this->objectManagerService->get(ReminderService::class),
            $this->objectManagerService->get(HtmlRenderer::class),
        );
    }
}
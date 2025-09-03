<?php

namespace App\Factories;

use App\Controller\ReminderDeleteController;
use App\Interfaces\FactoryInterface;
use App\Services\HtmlRenderer;
use App\Services\ObjectManagerService;
use App\Services\ReminderService;
use App\Services\RoomsService;

class ReminderDeleteControllerFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(string $className): object
    {
        return new ReminderDeleteController(
            $this->objectManagerService->get(ReminderService::class),
            $this->objectManagerService->get(RoomsService::class),
            $this->objectManagerService->get(HtmlRenderer::class),
        );
    }
}
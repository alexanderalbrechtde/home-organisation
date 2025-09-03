<?php

namespace App\Factories;

use App\Controller\ReminderSubmitController;
use App\Interfaces\FactoryInterface;
use App\Services\HtmlRenderer;
use App\Services\ObjectManagerService;
use App\Services\ReminderCreateService;
use App\Services\ReminderService;
use App\Services\RoomsService;

class ReminderSubmitControllerFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(string $className): object
    {
        return new ReminderSubmitController(
            $this->objectManagerService->get(ReminderCreateService::class),
            $this->objectManagerService->get(RoomsService::class),
            $this->objectManagerService->get(HtmlRenderer::class),
            $this->objectManagerService->get(ReminderService::class),
        );
    }
}
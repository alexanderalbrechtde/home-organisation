<?php

namespace App\Factories;

use App\Controller\ReminderSubmitController;
use App\Interfaces\FactoryInterface;
use App\Services\HtmlRenderer;
use App\Services\ObjectManagerService;
use App\Services\ReminderService;
use App\Services\RoomsService;

class ReminderSubmitControllerFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(): object
    {
        return new ReminderSubmitController(
            $this->objectManagerService->get(ReminderService::class),
            $this->objectManagerService->get(RoomsService::class),
            $this->objectManagerService->get(HtmlRenderer::class),
        );
    }
}
<?php
namespace App\Factories;

use App\Interfaces\FactoryInterface;
use App\Services\DashboardService;
use App\Services\ObjectManagerService;
use App\Services\ReminderService;

class DashboardServiceFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(): object
    {
        return new DashboardService($this->objectManagerService->get(ReminderService::class));
    }
}
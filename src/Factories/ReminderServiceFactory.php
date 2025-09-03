<?php
namespace App\Factories;

use App\Interfaces\FactoryInterface;
use App\Services\ObjectManagerService;
use App\Services\ReminderService;
use PDO;

class ReminderServiceFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(): object
    {
        return new ReminderService($this->objectManagerService->get(PDO::class));
    }
}
<?php

namespace App\Factories;

use App\Interfaces\FactoryInterface;
use App\Services\ObjectManagerService;
use App\Services\ReminderCreateService;
use PDO;

class ReminderCreateServiceFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(string $className): object
    {
        return new ReminderCreateService($this->objectManagerService->get(PDO::class));
    }
}
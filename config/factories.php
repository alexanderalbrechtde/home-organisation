<?php

use App\Factories\PDOFactory;
use Framework\Factories\EventManagerFactory;
use Framework\Services\EventManager;

return [
    PDO::class => PDOFactory::class,
    EventManager::class => EventManagerFactory::class
];
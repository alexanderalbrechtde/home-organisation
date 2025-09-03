<?php

namespace App\Factories;

use App\Interfaces\FactoryInterface;
use App\Services\ObjectManagerService;
use PDO;

class PDOFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(): object
    {
        $pdo = new PDO('sqlite:' . __DIR__ . '/../../data/home-organisation.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }
}
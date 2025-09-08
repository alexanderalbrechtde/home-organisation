<?php

namespace App\Factories;

use Framework\Interfaces\FactoryInterface;
use PDO;

class PDOFactory implements FactoryInterface
{
    public function __construct()
    {
    }

    public function produce(string $className): object
    {
        $pdo = new PDO('sqlite:' . __DIR__ . '/../../data/home-organisation.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }
}
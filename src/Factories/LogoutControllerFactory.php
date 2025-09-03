<?php

namespace App\Factories;

use App\Controller\LogoutController;
use App\Interfaces\FactoryInterface;
use App\Services\HtmlRenderer;
use App\Services\ObjectManagerService;

class LogoutControllerFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(string $className): object
    {
        return new LogoutController($this->objectManagerService->get(HtmlRenderer::class));
    }
}
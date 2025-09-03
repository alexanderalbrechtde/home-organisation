<?php

namespace App\Factories;

use App\Controller\LoginController;
use App\Interfaces\FactoryInterface;
use App\Services\HtmlRenderer;
use App\Services\ObjectManagerService;

class LoginControllerFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(string $className): object
    {
        return new LoginController($this->objectManagerService->get(HtmlRenderer::class));
    }
}
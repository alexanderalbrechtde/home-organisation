<?php

namespace App\Factories;

use App\Controller\RegisterController;
use App\Interfaces\FactoryInterface;
use App\Services\HtmlRenderer;
use App\Services\ObjectManagerService;

class RegisterControllerFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(string $className): object
    {
        return new RegisterController($this->objectManagerService->get(HtmlRenderer::class));
    }
}
<?php
namespace App\Factories;

use App\Controller\ErrorController;
use App\Interfaces\FactoryInterface;
use App\Services\HtmlRenderer;
use App\Services\ObjectManagerService;

class ErrorControllerFactory implements FactoryInterface
{
    public function __construct(private ObjectManagerService $objectManagerService)
    {
    }

    public function produce(string $className): object
    {
        return new ErrorController($this->objectManagerService->get(HtmlRenderer::class));
    }
}
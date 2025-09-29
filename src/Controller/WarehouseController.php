<?php

namespace App\Controller;

use App\Services\WarehouseService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Requests\httpRequests;
use Framework\Responses\HtmlResponse;
use Framework\Services\HtmlRenderer;

class WarehouseController implements ControllerInterface
{
    public function __construct(
        private WarehouseService $warehouseService,
        private HtmlRenderer $htmlRenderer
    ) {
    }

    function handle(httpRequests $httpRequest): ResponseInterface
    {
        if (!$httpRequest->getSessionLoggedIn()) {
            header('Location: /login');
            exit;
        }

        $items = $this->warehouseService->getItems($httpRequest->getSession()['user_id']);
        $rooms = $this->warehouseService->getRoomNames($httpRequest->getSession()['user_id']);

        return new HtmlResponse($this->htmlRenderer->render('warehouse.phtml', [
            'error' => $error ?? null,
            'items' => $items,
            'rooms' => $rooms,
        ]));
    }
}
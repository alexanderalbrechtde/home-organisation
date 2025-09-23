<?php

namespace App\Controller;

use App\Services\WarehouseService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Requests\httpRequests;
use Framework\Responses\HtmlResponse;
use Framework\Responses\RedirectResponse;
use Framework\Services\HtmlRenderer;

class WarehouseSubmitController implements ControllerInterface
{
    public function __construct(
        private WarehouseService $warehouseService,
        private HtmlRenderer $htmlRenderer
    ) {
    }

    function handle(httpRequests $httpRequest): ResponseInterface
    {
        $warehouse = $this->warehouseService->edit(
            (int)($httpRequest->getSession()['user_id']),
            (int)($httpRequest->getPayload()['room_id']),
            $httpRequest->getPayload()['name'],
            $httpRequest->getPayload()['category'],
            $httpRequest->getPayload()['amount'],
        );
        if (!$warehouse) {
            return new HtmlResponse($this->htmlRenderer->render('warehouse.phtml', [
                'error' => 'creation failed',
                'items' => $this->warehouseService->getItems($httpRequest->getSession()['user_id']),
                'rooms' => $this->warehouseService->getRoomNames($httpRequest->getSession()['user_id'])
            ]));
        }

        return new HtmlResponse($this->htmlRenderer->render('warehouse.phtml', [
            'error' => 'creation success',
            'items' => $this->warehouseService->getItems($httpRequest->getSession()['user_id']),
            'rooms' => $this->warehouseService->getRoomNames($httpRequest->getSession()['user_id'])
        ]));
    }
}
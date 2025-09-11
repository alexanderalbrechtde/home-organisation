<?php

namespace App\Controller;

use App\Services\WarehouseService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
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

    function handle($post, $get, $server, &$session): ResponseInterface
    {
        $warehouse = $this->warehouseService->edit(
            (int)($session['user_id']),
            (int)($post['room_id']),
            $post['name'],
            $post['category'],
            $post['amount'],
        );
        if (!$warehouse) {
            return new HtmlResponse($this->htmlRenderer->render('warehouse.phtml', [
                'error' => 'creation failed',
                'items' => $this->warehouseService->getItems($session['user_id']),
                'rooms' => $this->warehouseService->getRoomNames($session['user_id'])
            ]));
        }

        return new HtmlResponse($this->htmlRenderer->render('warehouse.phtml', [
            'error' => 'creation success',
            'items' => $this->warehouseService->getItems($session['user_id']),
            'rooms' => $this->warehouseService->getRoomNames($session['user_id'])
        ]));
    }
}
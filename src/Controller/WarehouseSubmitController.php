<?php

namespace App\Controller;

use App\Services\WarehouseService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Responses\RedirectResponse;

class WarehouseSubmitController implements ControllerInterface
{
    public function __construct(private WarehouseService $warehouseService)
    {
    }

    function handle($post, $get, $server, &$session): ResponseInterface
    {
        $warehouse = $this->warehouseService->edit(
            $session['user_id'],
            (int)($post['room_id']),
            $post['name'],
            $post['category'],
            $post['amount'],
        );
        if (!$warehouse) {
            return new RedirectResponse('Location: /warehouse?message=creation_failed');
        }

        return new RedirectResponse('Location: /warehouse?message=creation_success');
    }
}
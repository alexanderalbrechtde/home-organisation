<?php

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Interfaces\ResponseInterface;
use App\Services\WarehouseService;
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
            $post['name'],
            $post['category'],
            $post['amount'],
            $session['room_name'],
            $session['created_for']
        );
        if (!$warehouse) {
            return new RedirectResponse('Location: /warehouse?message=creation_failed');
        }

        return new RedirectResponse('Location: /warehouse?message=creation_success');
    }
}
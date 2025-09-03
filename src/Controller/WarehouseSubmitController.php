<?php

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Interfaces\ResponseInterface;
use App\Responses\RedirectResponse;
use App\Services\WarehouseService;

class WarehouseSubmitController implements ControllerInterface
{
    public function __construct(private WarehouseService $warehouseService)
    {
    }

    function handle($post, $get, $server, &$session): ResponseInterface
    {
        $warehouse = $this->warehouseService->edit(
            $post['name'],
            $post['category'],
            $post['amount']
        );
        if (!$warehouse) {
            return new RedirectResponse('Location: /warehouse?message=creation_failed');
        }

        return new RedirectResponse('Location: /warehouse?message=creation_success');
    }
}
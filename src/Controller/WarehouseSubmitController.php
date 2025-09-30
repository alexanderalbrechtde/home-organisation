<?php

namespace App\Controller;

use App\Services\WarehouseService;
use App\Validators\WarehouseSubmitValidator;
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
        private HtmlRenderer $htmlRenderer,
        private WarehouseSubmitValidator $payloadValidator
    ) {
    }

    function handle(httpRequests $httpRequest): ResponseInterface
    {
        $valid = $this->payloadValidator->validate($httpRequest->getPayload());
        if (!$valid) {
            $allErrors = $this->payloadValidator->getMessages();

            foreach ($allErrors as $field => $messages) {
                foreach ($messages as $message) {
                    $_SESSION['flashMessages'][$field][] = $message;
                }
            }

            return new RedirectResponse("/warehouse");
        }

        $warehouse = $this->warehouseService->edit(
            (int)($httpRequest->getSession()['user_id']),
            (int)($httpRequest->getPayload()['room_id']),
            $httpRequest->getPayload()['name'],
            $httpRequest->getPayload()['category'],
            $httpRequest->getPayload()['amount'],
        );
        if (!$warehouse) {
            return new RedirectResponse("/warehouse");
        }

        return new RedirectResponse("/warehouse");
    }
}
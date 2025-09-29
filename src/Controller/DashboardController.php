<?php

namespace App\Controller;

use App\Services\DashboardService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Requests\httpRequests;
use Framework\Responses\HtmlResponse;
use Framework\Services\HtmlRenderer;

class DashboardController implements ControllerInterface
{

    public function __construct(
        private HtmlRenderer $htmlRenderer,
        private DashboardService $dashboardService
    ) {
    }

    function handle(httpRequests $httpRequest): ResponseInterface
    {
        if (!$httpRequest->getSessionLoggedIn()) {
            header('Location: /login');
            exit;
        }

        $items = $this->dashboardService->getTaskItems();

        return new HtmlResponse($this->htmlRenderer->render('home.phtml', [
            'post' => $httpRequest->getPayload(),
            'dashboardService' => $this->dashboardService,
            'items' => $items
        ]));
    }

}
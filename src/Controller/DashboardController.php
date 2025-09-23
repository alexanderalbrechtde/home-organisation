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
        if (!isset($httpRequest->getSession()['logged_in']) || $httpRequest->getSession()['logged_in'] !== true) {
            header('Location: /login');
        }

        $items = $this->dashboardService->getTaskItems();

        return new HtmlResponse($this->htmlRenderer->render('home.phtml', [
            'post' => $httpRequest->getPayload(),
            'dashboardService' => $this->dashboardService,
            'items' => $items
        ]));
    }

}
<?php

namespace App\Controller;

use App\Services\DashboardService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Responses\HtmlResponse;
use Framework\Services\HtmlRenderer;

class DashboardController implements ControllerInterface
{

    public function __construct(
        private HtmlRenderer $htmlRenderer,
        private DashboardService $dashboardService
    ) {
    }

    function handle($post, $get, $server, &$session): ResponseInterface
    {
        if (!isset($_SESSION['logged_in'])||$_SESSION['logged_in']!==true) {
            header('Location: /login');
        }

        $items = $this->dashboardService->getReminderItems();

        return new HtmlResponse($this->htmlRenderer->render('home.phtml', [
            'post' => $_POST,
            'dashboardService' => $this->dashboardService,
            'items' => $items
        ]));
    }

}
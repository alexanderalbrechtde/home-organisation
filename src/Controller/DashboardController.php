<?php

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Interfaces\ResponseInterface;
use App\Responses\HtmlResponse;
use App\Services\DashboardService;
use App\Services\HtmlRenderer;

class DashboardController implements ControllerInterface
{

    public function __construct(
        private HtmlRenderer $htmlRenderer,
        private DashboardService $dashboardService
    ) {
    }

    function handle($post, $get, $server, &$session): ResponseInterface
    {
        if (!$_SESSION['logged_in']) {
            header('Location: /login');
        }

        $data = [
            'post' => $_POST,
            'dashboardService' => $this->dashboardService
        ];
        return new HtmlResponse($this->htmlRenderer->render('home.phtml', $data));

    }

}
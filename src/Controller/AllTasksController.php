<?php

namespace App\Controller;

use App\Services\AllTasksService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Requests\httpRequests;
use Framework\Responses\HtmlResponse;
use Framework\Services\HtmlRenderer;

class AllTasksController implements ControllerInterface
{
    public function __construct(
        private HtmlRenderer $htmlRenderer,
        private AllTasksService $allTasksService
    ) {
    }

    function handle(httpRequests $httpRequest): ResponseInterface
    {
        if (!$httpRequest->getSessionLoggedIn()) {
            header('Location: /login');
            exit;
        }

        $items = $this->allTasksService->getTaskItems();


        return new HtmlResponse($this->htmlRenderer->render('allTasks.phtml', [
            'items' => $items,
            'allTasksService' => $this->allTasksService,
            'post' => $httpRequest->getPayload()
        ]));
    }
}
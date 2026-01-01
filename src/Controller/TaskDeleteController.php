<?php

namespace App\Controller;

use App\Services\RoomsService;
use App\Services\TaskService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Requests\httpRequests;
use Framework\Responses\HtmlResponse;
use Framework\Responses\RedirectResponse;
use Framework\Services\HtmlRenderer;

class TaskDeleteController implements ControllerInterface
{
    public function __construct(
        private TaskService $taskService
    ) {
    }

    function handle(httpRequests $httpRequest): ResponseInterface
    {
        $taskId = (int)$httpRequest->getPayload()['task_id'] ?? null;
        $roomId = (int)$httpRequest->getPayload()['room_id'] ?? null;

       $deleted = $this->taskService->deleteTaskById($taskId);

        if($deleted){
            return new RedirectResponse('/room/' . $roomId . '?delete_succeed');
        }else{
            return new RedirectResponse('/room/' . $roomId . '?delete_failed');
        }

    }
}
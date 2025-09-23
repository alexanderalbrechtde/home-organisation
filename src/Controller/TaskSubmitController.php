<?php

namespace App\Controller;

use App\Services\TaskCreateService;
use App\Services\TaskService;
use App\Services\RoomsService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Requests\httpRequests;
use Framework\Responses\HtmlResponse;
use Framework\Services\HtmlRenderer;

class TaskSubmitController implements ControllerInterface
{
    public function __construct(
        private TaskCreateService $taskCreateService,
        private RoomsService $roomsService,
        private HtmlRenderer $htmlRenderer,
        private TaskService $taskService,
    ) {
    }

    function handle(httpRequests $httpRequest): ResponseInterface
    {
        $roomId = isset($httpRequest->getPayload()['room_id']) ? (int)$httpRequest->getPayload()['room_id'] : null;

        $create = $this->taskCreateService->create(
            $httpRequest->getSession()['user_id'],
            $httpRequest->getPayload()['room_id'],
            $httpRequest->getPayload()['task_title'],
            $httpRequest->getPayload()['task_notes'],
            $httpRequest->getPayload()['task_due_at'],
            $httpRequest->getPayload()['task_priority'],
            $httpRequest->getPayload()['task_repeat'],
            $httpRequest->getPayload()['task_repeat_rule'],
            $httpRequest->getPayload()['task_created_at']
        );

        if (!$create) {
            $room = $this->roomsService->getRoom($roomId);
            $task = $this->taskService->getTaskByRoomId($roomId);


            return new HtmlResponse($this->htmlRenderer->render('room.phtml', [
                'room' => $room,
                'task' => $task,
                'timers' => $task,
                'error' => 'creation_failed'
            ]));
        }

        $room = $this->roomsService->getRoom($roomId);
        $task = $this->taskService->getTaskByRoomId($roomId);

        return new HtmlResponse($this->htmlRenderer->render('room.phtml', [
            'room' => $room,
            'task' => $task,
            'timers' => $task,
            'success' => 'creation_success'
        ]));
    }
}
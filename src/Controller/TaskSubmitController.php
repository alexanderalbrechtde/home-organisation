<?php

namespace App\Controller;

use App\Services\TaskCreateService;
use App\Services\TaskService;
use App\Services\RoomsService;
use App\Validators\TaskSubmitValidator;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Requests\httpRequests;
use Framework\Responses\HtmlResponse;
use Framework\Services\HtmlRenderer;
use Framework\Validators\PayloadValidator;

class TaskSubmitController implements ControllerInterface
{
    public function __construct(
        private TaskCreateService $taskCreateService,
        private RoomsService $roomsService,
        private HtmlRenderer $htmlRenderer,
        private TaskService $taskService,
        private TaskSubmitValidator $payloadValidator,
    ) {
    }

    function handle(httpRequests $httpRequest): ResponseInterface
    {
        $roomId = isset($httpRequest->getPayload()['room_id']) ? (int)$httpRequest->getPayload()['room_id'] : null;
        $valid = $this->payloadValidator->validate($httpRequest->getPayload());
        //dd($valid);

        if (!$valid) {
            $errors = $this->payloadValidator->getMessages();
            //dd($errors);
            $room = $this->roomsService->getRoom($roomId);
            $task = $this->taskService->getTaskByRoomId($roomId);
            $html = $this->htmlRenderer->render('room.phtml', [
                'errors' => $errors,
                'room' => $room,
                'task' => $task,
                'timers' => $task,
            ]);
            return new HtmlResponse($html);
        }

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
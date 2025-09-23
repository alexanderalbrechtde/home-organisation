<?php

namespace App\Controller;

use App\Services\TaskService;
use App\Services\RoomsService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Requests\httpRequests;
use Framework\Responses\HtmlResponse;
use Framework\Services\HtmlRenderer;

class RoomController implements ControllerInterface
{
    public function __construct(
        private RoomsService $roomsService,
        private TaskService $taskService,
        private HtmlRenderer $htmlRenderer
    ) {
    }

    function handle(httpRequests $httpRequest): ResponseInterface
    {

        $roomId = $httpRequest->getRouteParameters('id');

        if ($roomId === null) {
            $rooms = $this->roomsService->getRooms($httpRequest->getSession()['user_id']);
            return new HtmlResponse($this->htmlRenderer->render('rooms.phtml', ['rooms' => $rooms]));
        }

        $room = $this->roomsService->getRoom($roomId);
        if (!$room) {
            return new HtmlResponse($this->htmlRenderer->render('404.phtml', []));
        }

        $task = $this->taskService->getTaskByRoomId($roomId);

        return new HtmlResponse($this->htmlRenderer->render('room.phtml', [
            'room' => $room,
            'task' => $task,
            'timers' => $task
        ]));
    }
}
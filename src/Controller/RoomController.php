<?php

namespace App\Controller;

use App\Services\TaskService;
use App\Services\RoomsService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
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

    function handle($post, $get, $server, &$session): ResponseInterface
    {
        //$id = isset($get['id']) && ctype_digit((string)$get['id']) ? (int)$get['id'] : null;

        $pathParts = explode('/', $server['PATH_INFO'] ?? '/');
        $id = $pathParts[2];


        if ($id === null) {
            $rooms = $this->roomsService->getRooms($session['user_id']);
            return new HtmlResponse($this->htmlRenderer->render('rooms.phtml', ['rooms' => $rooms]));
        }

        $room = $this->roomsService->getRoom($id);
        if (!$room) {
            return new HtmlResponse($this->htmlRenderer->render('404.phtml', []));
        }

        $task = $this->taskService->getTaskByRoomId($id);

        return new HtmlResponse($this->htmlRenderer->render('room.phtml', [
            'room' => $room,
            'task' => $task,
            'timers' => $task
        ]));
    }
}
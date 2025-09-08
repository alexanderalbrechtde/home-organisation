<?php

namespace App\Controller;

use App\Services\ReminderService;
use App\Services\RoomsService;
use Framework\Interfaces\ControllerInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Responses\HtmlResponse;
use Framework\Services\HtmlRenderer;

class RoomController implements ControllerInterface
{
    public function __construct(
        private RoomsService $roomsService,
        private ReminderService $reminderService,
        private HtmlRenderer $htmlRenderer
    ) {
    }

    function handle($post, $get, $server, &$session): ResponseInterface
    {
        $id = isset($get['id']) && ctype_digit((string)$get['id']) ? (int)$get['id'] : null;

        if ($id === null) {
            $rooms = $this->roomsService->getRooms();
            return new HtmlResponse($this->htmlRenderer->render('rooms.phtml', ['rooms' => $rooms]));
        }

        $room = $this->roomsService->getRoom($id);
        if (!$room) {
            return new HtmlResponse($this->htmlRenderer->render('404.phtml', []));
        }

        $reminders = $this->reminderService->getRemindersByRoomId($id);

        return new HtmlResponse($this->htmlRenderer->render('room.phtml', [
            'room' => $room,
            'reminders' => $reminders,
            'timers' => $reminders
        ]));
    }
}
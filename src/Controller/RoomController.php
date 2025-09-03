<?php

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Services\HtmlRenderer;
use App\Services\ReminderService;
use App\Services\RoomsService;

class RoomController implements ControllerInterface
{
    public function __construct(
        private RoomsService $roomsService,
        private ReminderService $reminderService,
        private HtmlRenderer $htmlRenderer
    ) {
    }

    function handle($post, $get, $server, &$session): string
    {
        $id = isset($get['id']) && ctype_digit((string)$get['id']) ? (int)$get['id'] : null;

        if ($id === null) {
            $rooms = $this->roomsService->getRooms();
            return $this->htmlRenderer->render('rooms.phtml', [
                'rooms' => $rooms
            ]);
        }

        $room = $this->roomsService->getRoom($id);
        if (!$room) {
            return $this->htmlRenderer->render('404.phtml', []);
        }

        $reminders = $this->reminderService->getRemindersByRoomId($id);

        return $this->htmlRenderer->render('room.phtml', [
            'room' => $room,
            'reminders' => $reminders,
            'timers' => $reminders
        ]);
    }
}
<?php

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Interfaces\ResponseInterface;
use App\Services\HtmlRenderer;
use App\Services\ReminderService;
use App\Services\RoomsService;
use App\Responses\HtmlResponse;

class ReminderDeleteController implements ControllerInterface
{
    public function __construct(
        private ReminderService $reminderService,
        private HtmlRenderer $htmlRenderer,
        private RoomsService $roomsService
    ) {
    }

    function handle($post, $get, $server, &$session): ResponseInterface
    {
        $reminderId = isset($post['reminder_id']) && ctype_digit((string)$post['reminder_id'])
            ? (int)$post['reminder_id']
            : null;
        $roomId = isset($post['room_id']) && ctype_digit((string)$post['room_id'])
            ? (int)$post['room_id']
            : null;

        if ($reminderId === null || $roomId === null) {
            $rooms = $this->roomsService->getRooms();
            $htmlRenderer = new HtmlRenderer();
            //return $htmlRenderer->render('rooms.phtml', [
            //    'rooms' => $rooms,
            //    'error' => 'missing_parameters'
            //]);
            return new HtmlResponse($this->htmlRenderer->render('rooms.phtml', [
                'rooms' => $rooms,
                'error' => 'missing_parameters'
            ]));
        }


        $this->reminderService->deleteReminderbyId($reminderId);

        $room = $this->roomsService->getRoom($roomId);
        if (!$room) {
            return new HtmlResponse($this->htmlRenderer->render('404.phtml'));
        }

        $reminders = $this->reminderService->getRemindersByRoomId($roomId);

        return new HtmlResponse($this->htmlRenderer->render('home.phtml', [
            'room' => $room,
            'reminders' => $reminders,
            'timers' => $reminders,
        ]));
    }
}
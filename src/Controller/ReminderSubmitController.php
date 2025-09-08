<?php

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Interfaces\ResponseInterface;
use App\Services\ReminderCreateService;
use App\Services\ReminderService;
use App\Services\RoomsService;
use Framework\Responses\HtmlResponse;
use Framework\Services\HtmlRenderer;

class ReminderSubmitController implements ControllerInterface
{
    public function __construct(
        private ReminderCreateService $reminderCreateService,
        private RoomsService $roomsService,
        private HtmlRenderer $htmlRenderer,
        private ReminderService $reminderService,
    ) {
    }

    function handle($post, $get, $server, &$session): ResponseInterface
    {
        $roomId = isset($post['room_id']) ? (int)$post['room_id'] : null;

        $create = $this->reminderCreateService->create(
            $session['user_id'],
            $post['room_id'],
            $post['reminder_title'],
            $post['reminder_notes'],
            $post['reminder_due_at'],
            $post['reminder_priority'],
            $post['reminder_status'],
            $post['reminder_created_at']
        );

        if (!$create) {
            $room = $this->roomsService->getRoom($roomId);
            $reminders = $this->reminderService->getRemindersByRoomId($roomId);


            return new HtmlResponse($this->htmlRenderer->render('room.phtml', [
                'room' => $room,
                'reminders' => $reminders,
                'timers' => $reminders,
                'error' => 'creation_failed'
            ]));
        }

        $room = $this->roomsService->getRoom($roomId);
        $reminders = $this->reminderService->getRemindersByRoomId($roomId);

        return new HtmlResponse($this->htmlRenderer->render('room.phtml', [
            'room' => $room,
            'reminders' => $reminders,
            'timers' => $reminders,
            'success' => 'creation_success'
        ]));
    }
}
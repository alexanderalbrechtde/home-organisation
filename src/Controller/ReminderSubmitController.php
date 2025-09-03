<?php
namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Services\HtmlRenderer;
use App\Services\ReminderService;
use App\Services\RoomsService;

class ReminderSubmitController implements ControllerInterface
{
    public function __construct(
        private ReminderService $reminderService,
        private RoomsService $roomsService,
        private HtmlRenderer $htmlRenderer
    ) {
    }

    function handle($post, $get, $server, &$session): string
    {
        $roomId = isset($post['room_id']) ? (int)$post['room_id'] : null;

        $create = $this->reminderService->create(
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
            // Fehler beim Anlegen: rendere die Raumansicht mit Fehlerstatus
            $room = $this->roomsService->getRoom($roomId);
            $reminders = $this->reminderService->getRemindersByRoomId($roomId);

            return $this->htmlRenderer->render('room.phtml', [
                'room' => $room,
                'reminders' => $reminders,
                'timers' => $reminders,
                'error' => 'creation_failed'
            ]);
        }

        // Erfolgreich angelegt: rendere Raumansicht mit success-Status
        $room = $this->roomsService->getRoom($roomId);
        $reminders = $this->reminderService->getRemindersByRoomId($roomId);

        return $this->htmlRenderer->render('room.phtml', [
            'room' => $room,
            'reminders' => $reminders,
            'timers' => $reminders,
            'success' => 'creation_success'
        ]);
    }
}
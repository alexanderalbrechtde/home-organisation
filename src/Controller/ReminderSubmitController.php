<?php

class ReminderSubmitController implements ControllerInterface
{

    function handle($post, $get, $server, &$session): string
    {
        $reminderService = new ReminderCreateService();
        $roomId = isset($post['room_id']) ? (int)$post['room_id'] : null;

        $create = $reminderService->create(
            $session['user_id'],
            $post['room_id'],
            $post['reminder_title'],
            $post['reminder_notes'],
            $post['reminder_due_at'],
            $post['reminder_repeat_rules'],
            $post['reminder_priority'],
            $post['reminder_status'],
            $post['reminder_created_at']
        );

        $service = new RoomsService();
        $htmlRenderer = new HtmlRenderer();

        if (!$create) {
            // Fehler beim Anlegen: rendere die Raumansicht mit Fehlerstatus
            $room = $service->getRoom($roomId);
            $reminderService2 = new ReminderService();
            $reminders = $reminderService2->getRemindersByRoomId($roomId);

            return $htmlRenderer->render('room.phtml', [
                'room' => $room,
                'reminders' => $reminders,
                'timers' => $reminders,
                'error' => 'creation_failed'
            ]);
        }

        // Erfolgreich angelegt: rendere Raumansicht mit success-Status
        $room = $service->getRoom($roomId);
        $reminderService2 = new ReminderService();
        $reminders = $reminderService2->getRemindersByRoomId($roomId);

        return $htmlRenderer->render('room.phtml', [
            'room' => $room,
            'reminders' => $reminders,
            'timers' => $reminders,
            'success' => 'creation_success'
        ]);
    }
}
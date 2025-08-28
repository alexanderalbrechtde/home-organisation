<?php


class ReminderDeleteController implements ControllerInterface
{

    function handle($post, $get, $server, &$session): string
    {
        $reminderService = new ReminderService();

        $reminderId = isset($post['reminder_id']) && ctype_digit((string)$post['reminder_id'])
            ? (int)$post['reminder_id']
            : null;
        $roomId = isset($post['room_id']) && ctype_digit((string)$post['room_id'])
            ? (int)$post['room_id']
            : null;

        if ($reminderId === null || $roomId === null) {
            $service = new RoomsService();
            $rooms = $service->getRooms();
            $htmlRenderer = new HtmlRenderer();
            return $htmlRenderer->render('rooms.phtml', [
                'rooms' => $rooms,
                'error' => 'missing_parameters'
            ]);
        }


        $reminderService->deleteReminderbyId($reminderId);

        $service = new RoomsService();
        $room = $service->getRoom($roomId);
        if (!$room) {
            $htmlRenderer = new HtmlRenderer();
            return $htmlRenderer->render('404.phtml', []);
        }

        $reminders = $reminderService->getRemindersByRoomId($roomId);

        $htmlRenderer = new HtmlRenderer();
        return $htmlRenderer->render('room.phtml', [
            'room' => $room,
            'reminders' => $reminders,
            'timers' => $reminders,
        ]);
    }
}
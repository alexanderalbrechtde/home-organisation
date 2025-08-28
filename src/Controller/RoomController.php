<?php

class RoomController implements ControllerInterface
{
    function handle($post, $get, $server, &$session): string
    {
        $service = new RoomsService();
        $htmlRenderer = new HtmlRenderer();

        $id = isset($get['id']) && ctype_digit((string)$get['id']) ? (int)$get['id'] : null;

        if ($id === null) {
            $rooms = $service->getRooms();
            return $htmlRenderer->render('rooms.phtml', [
                'rooms' => $rooms
            ]);
        }

        $room = $service->getRoom($id);
        if (!$room) {
            return $htmlRenderer->render('404.phtml', []);
        }

        $reminderService = new ReminderService();
        $reminders = $reminderService->getRemindersByRoomId($id);

        return $htmlRenderer->render('room.phtml', [
            'room' => $room,
            'reminders' => $reminders,
            'timers' => $reminders
        ]);
    }
}
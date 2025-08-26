<?php


class ReminderDeleteController implements ControllerInterface
{

    function handle($post, $get, $server, &$session): string
    {
        $reminderService = new ReminderService();
        $roomId = isset($post['room_id']) ? (int)$post['room_id'] : null;

        $reminderId = isset($post['reminder_id']) ? (int)$post['reminder_id'] : null;

        if ($reminderId) {
            $reminderService->deleteReminderbyId($reminderId);
        }

        header("Location: /room?id=" . urlencode((string)$roomId) . "&status=successfully_deleted");
        exit;


    }
}
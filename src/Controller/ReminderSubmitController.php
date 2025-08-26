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
        if (!$create) {
            header("Location: /room?id=" . urlencode((string)$roomId) . "&status=creation_failed");
            return '';
        }
        header("Location: /room?id=" . urlencode((string)$roomId) . "&status=creation_success");
        return '';
    }
}
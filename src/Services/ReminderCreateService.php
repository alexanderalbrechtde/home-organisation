<?php

namespace App\Services;

use PDO;

class ReminderCreateService
{
    public function __construct(private PDO $pdo)
    {
    }

    function create(
        int $userId,
        int $roomId,
        string $title,
        string $notes,
        string $due_at,
        string $priority,
        string $status,
        string $created_at
    ) {
        if (empty($userId) || empty($roomId) || empty($title) || empty($notes) || empty($due_at) || empty($priority) || empty($status)) {
            return false;
        }


        $statement = $this->pdo->prepare(
            'INSERT INTO reminder (created_by, created_for, title, notes, due_at, priority, status, created_at) 
                    VALUES (:created_by, :created_for, :title, :notes, :due_at, :priority, :status, :created_at)'
        );
        $statement->execute([
            'created_by' => $userId,
            'created_for' => $roomId,
            'title' => $title,
            'notes' => $notes,
            'due_at' => $due_at,
            'priority' => $priority,
            'status' => $status,
            'created_at' => $created_at
        ]);
        $reminderId = $this->pdo->lastInsertId();

        $statement = $this->pdo->prepare(
            'INSERT INTO user_to_reminder (owner_user_id, reminder_id) VALUES (:owner_user_id, :reminder_id)'
        );
        $statement->execute([
            'owner_user_id' => $userId,
            'reminder_id' => $reminderId,
        ]);
        $stmt2 = $this->pdo->prepare(
            'INSERT INTO room_to_reminder (room_id, reminder_id) VALUES (:room_id, :reminder_id)'
        );
        $stmt2->execute([
            'room_id' => $roomId,
            'reminder_id' => $reminderId,
        ]);

        return true;
    }
}
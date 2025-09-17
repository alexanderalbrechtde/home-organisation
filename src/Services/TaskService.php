<?php

namespace App\Services;

use DateTime;
use DateTimeInterface;
use PDO;

class TaskService
{
    public function __construct(private PDO $pdo)
    {
    }

    public function getTaskByRoomId(int $id): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT t.id, t.title, t.notes, t.due_at, t.priority, t.status, t.created_at
             FROM task t
             INNER JOIN room_to_task rt ON rt.task_id = t.id
             WHERE rt.room_id = :id
             ORDER BY t.due_at"
        );
        $stmt->execute(['id' => $id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }


    public function deleteTaskById(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM task WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getTask(int $limit = 3, bool $descending = true): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT t.id, t.title, t.notes, t.due_at, t.priority, t.status, t.created_at,
                    GROUP_CONCAT(DISTINCT ro.name) AS rooms
             FROM task t
             LEFT JOIN room_to_task rt ON rt.task_id = t.id
             LEFT JOIN room ro ON ro.id = rt.room_id
             WHERE t.due_at IS NOT NULL
             GROUP BY t.id
             ORDER BY t.due_at ASC
             LIMIT :limit"
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $task = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        if ($descending) {
            $task = array_reverse($task);
        }
        return $task;
    }

    public function showTimer($dueAt): string
    {
        if (empty($dueAt)) {
            return '';
        }
        $now = new DateTime();
        if ($dueAt instanceof DateTimeInterface) {
            $dt = clone $dueAt;
        } else {
            $dt = new DateTime((string)$dueAt);
        }
        if ($dt > $now) {
            $difference = $now->diff($dt);
            $remaining = $difference->format('%a Tage, %h Std, %i Min');
        } else {
            $remaining = 'abgelaufen';
        }
        return $remaining . ' (am ' . $dt->format('d.m.Y H:i') . ')';
    }

    public function getAllTasks(bool $descending = true): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT t.id, t.title, t.notes, t.due_at, t.priority, t.status, t.created_at,
            GROUP_CONCAT(DISTINCT ro.name) AS rooms
     FROM task t
     LEFT JOIN room_to_task rt ON rt.task_id = t.id
     LEFT JOIN room ro ON ro.id = rt.room_id
     WHERE t.due_at IS NOT NULL
     GROUP BY t.id
     ORDER BY t.due_at ASC"
        );
        $stmt->execute();

        $task = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        if ($descending) {
            $task = array_reverse($task);
        }
        return $task;
    }
}
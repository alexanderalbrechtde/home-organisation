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
            "SELECT t.id, t.title, t.notes, t.due_at, t.priority, t.repeat, t.repeat_rule, t.created_at, t.deleted
             FROM task t
             INNER JOIN room_to_task rt ON rt.task_id = t.id
             WHERE rt.room_id = :id & t.deleted = false
             ORDER BY t.due_at"
        );
        $stmt->execute(['id' => $id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }


    public function deleteTaskById(int $id): bool
    {
        $stmt = $this->pdo->prepare('Update task set deleted = true where id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function getTask(int $limit = 3, bool $descending = true): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT t.id, t.title, t.notes, t.due_at, t.priority, t.repeat, t.repeat_rule, t.created_at, t.deleted
             FROM task t
             LEFT JOIN room_to_task rt ON rt.task_id = t.id
             LEFT JOIN room ro ON ro.id = rt.room_id
             WHERE t.due_at IS NOT NULL AND t.deleted = false
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
            $remaining = 'ABGELAUFEN!!!';
        }
        return $remaining . ' (am ' . $dt->format('d.m.Y H:i') . ')';
    }

    public function getAllTasks(bool $descending = true): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT t.id, t.title, t.notes, t.due_at, t.priority, t.repeat, t.repeat_rule, t.created_at, t.deleted
     FROM task t
     LEFT JOIN room_to_task rt ON rt.task_id = t.id
     LEFT JOIN room ro ON ro.id = rt.room_id
     WHERE t.due_at IS NOT NULL AND t.deleted = false
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

    public function getArchiveTasks(bool $descending = true): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT t.id, t.title, t.notes, t.due_at, t.priority,t.repeat, t.repeat_rule, t.created_at, t.deleted
     FROM task t
     LEFT JOIN room_to_task rt ON rt.task_id = t.id
     LEFT JOIN room ro ON ro.id = rt.room_id
     WHERE t.due_at IS NOT NULL AND t.deleted = 1
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

    public function repeatTask(string $due_at, bool $repeat, string $repeate_rule): bool
    {
        if ($repeat === true) {
            $goal = strtotime($due_at);
            $now = strtotime("now");

            $diff = $goal - $now;

            if ($diff <= 0) {
                $stmt = $this->pdo->prepare(
                    "SELECT t.id, t.title, t.notes, t.due_at, t.priority,t.repeat, t.repeat_rule, t.created_at, t.deleted 
                    FROM task t
                    LEFT JOIN room_to_task rt ON rt.task_id = t.id
                    LEFT JOIN room ro ON ro.id = rt.room_id
                    WHERE t.repeat is true AND t.deleted = false
                    GROUP BY t.id"
                );

            }
            return true;
        } else {
            return false;
        }
    }
}
<?php

namespace App\Services;

use App\Entities\TaskEntity;
use DateTime;
use DateTimeInterface;
use Framework\Interfaces\EntityInterface;
use Framework\Services\OrmService;
use PDO;

class TaskService
{
    public function __construct(private PDO $pdo, private OrmService $ormService)
    {
    }

    public function getTaskByRoomId(int $roomId): array
    {
        $tasks = $this->ormService->findBy(
            [
                'room_id' => $roomId,
                'deleted' => ''
            ],
            TaskEntity::class
        );
        return $tasks;
    }

    //not   work at all; same id error
    public function deleteTaskById(int $taskId): bool
    {
        $task = $this->getTaskById($taskId);
        //dd($task);

        $task->deleted = 1;
        return $this->ormService->save($task);

//        $stmt = $this->pdo->prepare('UPDATE task SET deleted = 1 WHERE id = :id');
//        return $stmt->execute(['id' => $id]);
    }

    public function getTaskById($taskId): EntityInterface
    {
        $task = $this->ormService->findOneBy(
            [
                'id' => $taskId
            ],
            TaskEntity::class
        );
        return $task;
    }

    public function getTask(int $limit = 3, bool $descending = true): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT t.id, t.title, t.notes, t.due_at, t.priority, t.repeat, t.repeat_rule, t.created_at, t.deleted
             FROM task t
             LEFT JOIN room_to_task rt ON rt.task_id = t.id
             LEFT JOIN room ro ON ro.id = rt.room_id
             WHERE t.due_at IS NOT NULL AND t.deleted = ''
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
     WHERE t.due_at IS NOT NULL AND t.deleted = ''
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
     WHERE t.due_at IS NOT NULL AND t.deleted = true
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

    public function repeatTask(int $taskId): bool
    {
        $stmt = $this->pdo->prepare(
            "SELECT t.*, rt.room_id FROM task t
             LEFT JOIN room_to_task rt ON rt.task_id = t.id
             WHERE t.id = :id AND t.deleted = 0"
        );
        $stmt->execute(['id' => $taskId]);
        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$task) {
            return false;
        }

        if (!(bool)$task['repeat']) {
            return false;
        }

        $rule = trim((string)$task['repeat_rule']);
        if ($rule === '' || $rule === 'false') {
            return false;
        }

        $increments = [
            '60_minutes' => '+1 hour',
            '120_minutes' => '+2 hours',
            '1_day' => '+1 day',
            '2_days' => '+2 days',
            '7_days' => '+7 days',
            '14_days' => '+14 days',
            '28_days' => '+28 days',
        ];

        $inc = $increments[$rule] ?? null;
        if ($inc === null) {
            return false;
        }

        $baseTimestamp = isset($task['due_at']) && $task['due_at']
            ? strtotime((string)$task['due_at'])
            : time();

        if ($baseTimestamp === false) {
            return false;
        }

        $newDueAt = date('Y-m-d H:i:s', strtotime($inc, $baseTimestamp));

        $creator = new TaskCreateService($this->pdo);
        return $creator->create(
            (int)$task['created_by'],
            (int)($task['room_id'] ?? $task['created_for']),
            (string)$task['title'],
            (string)$task['notes'],
            $newDueAt,
            (string)$task['priority'],
            true,
            (string)$task['repeat_rule'],
            date('Y-m-d H:i:s')
        );
    }
}
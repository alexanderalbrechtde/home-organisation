<?php

namespace App\Services;

use App\Entities\TaskEntity;
use App\Entities\UserEntity;
use App\Entities\UserToTaskEntity;
use Framework\Services\OrmService;
use PDO;

class TaskCreateService
{
    public function __construct(private PDO $pdo, private OrmService $ormService)
    {
    }

    function create(
        int $userId,
        int $roomId,
        string $title,
        string $notes,
        string $due_at,
        string $priority,
        bool $repeat,
        string $repeat_rule,
        string $created_at
    ) {
        $user = $this->ormService->findOneBy(
            [
                'id' => $userId
            ],
            UserEntity::class
        );

        $task = new TaskEntity(
            null,
            $title,
            $notes,
            $due_at,
            $priority,
            $repeat,
            $repeat_rule,
            $created_at,
            0,
            0,
            null,
            null
        );

        $this->ormService->save($task);

        $taskId = $task->id;

        $userTask = new UserToTaskEntity(null, $user, $taskId);
        $this->ormService->save($userTask);
        return true;


        //$statement = $this->pdo->prepare(
        //    'INSERT INTO task (user_id, room_id, title, notes, due_at, priority, repeat, repeat_rule, created_at)
        //            VALUES (:created_by, :created_for, :title, :notes, :due_at, :priority, :repeat, :repeat_rule, :created_at)'
        //);
        //$statement->execute([
        //    'created_by' => $userId,
        //    'created_for' => $roomId,
        //    'title' => $title,
        //    'notes' => $notes,
        //    'due_at' => $due_at,
        //    'priority' => $priority,
        //    'repeat' => $repeat,
        //    'repeat_rule' => $repeat_rule,
        //    'created_at' => $created_at
        //]);
        //$taskId = $this->pdo->lastInsertId();
//
        //$statement = $this->pdo->prepare(
        //    'INSERT INTO user_to_task (owner_id, task_id) VALUES (:owner_id, :task_id)'
        //);
        //$statement->execute([
        //    'owner_id' => $userId,
        //    'task_id' => $taskId,
        //]);
        //$stmt2 = $this->pdo->prepare(
        //    'INSERT INTO room_to_task (room_id, task_id) VALUES (:room_id, :task_id)'
        //);
        //$stmt2->execute([
        //    'room_id' => $roomId,
        //    'task_id' => $taskId,
        //]);
//
        //return true;
    }
}
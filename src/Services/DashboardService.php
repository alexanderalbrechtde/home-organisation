<?php

namespace App\Services;


use App\Entities\TaskEntity;
use Framework\Services\OrmService;

class DashboardService
{

    public function __construct(
        private TaskService $taskService,
        private OrmService  $ormService
    )
    {
    }

    public function getTaskItems(int $limit = 3): array
    {
        $rawItems = $this->taskService->getDashboardTasks($limit, true);
        if (empty($rawItems)) {
            return [];
        }
        $result = [];
        foreach ($rawItems as $t) {
            $title = $t->title ?? '';

            $rooms = trim((string)($t->room_id ?? ''));
            $roomTagHtml = '';
            if ($rooms !== '') {
                $roomTagHtml = '<small class="tag">(Raum: ' . $rooms . ')</small>';
            }

            $dueAt = $t->due ?? null;
            $dueTs = $dueAt ? strtotime((string)$dueAt) : null;
            $now = time();
            $status = 'ok';
            if ($dueTs !== null) {
                if ($dueTs < $now) {
                    $status = 'expired';
                } elseif (($dueTs - $now) <= 3600) {
                    $status = 'warning';
                }
            }

            $dueTextRaw = $this->taskService->showTimer($dueAt);
            $dueText = $dueTextRaw;

            $notes = ($t->notes ?? '');
            $notesHtml = nl2br($notes);

            $result[] = [
                'id' => $t->id,
                'title' => $title,
                'roomTagHtml' => $roomTagHtml,
                'dueText' => $dueText,
                'notesHtml' => $notesHtml,
                'status' => $status
            ];
        }
        return $result;
    }

    public function checkTask(int $taskId): bool
    {
        $task = $this->ormService->findOneBy(['id' => $taskId], TaskEntity::class);
        $task->checked = 1;
        return $this->ormService->save($task);
    }
}
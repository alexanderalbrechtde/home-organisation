<?php

namespace App\Services;

class AllTasksService
{
    public function __construct(private TaskService $taskService)
    {
    }

    public function getTaskItems(): array
    {
        $rawItems = $this->taskService->getAllTasks(true);
        if (empty($rawItems) || !is_array($rawItems)) {
            return [];
        }

        $result = [];
        foreach ($rawItems as $t) {
            $title = $t['title'] ?? '';

            $rooms = trim((string)($t['rooms'] ?? ''));
            $roomTagHtml = '';
            if ($rooms !== '') {
                $roomTagHtml = '<small class="tag">(Raum: ' . $rooms . ')</small>';
            }

            $dueAt = $t['due_at'] ?? null;
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
            $dueText = (string)$dueTextRaw;

            $notes = (string)($t['notes'] ?? '');
            $notesHtml = nl2br($notes);

            $result[] = [
                'title' => $title,
                'roomTagHtml' => $roomTagHtml,
                'dueText' => $dueText,
                'notesHtml' => $notesHtml,
                'status' => $status
            ];
        }
        return $result;
    }
}
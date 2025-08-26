<?php

use Dtos\ReminderDto;

class ReminderService
{
    public function getReminderbyName(string $title): ?ReminderDto
    {
        $pdo = new PDO('sqlite:' . __DIR__ . '/../../data/home-organisation.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare(
            "SELECT title, notes, due_at, repeat_rules, priority, status, created_at FROM reminder WHERE title = :title"
        );
        $stmt->execute(['title' => $title]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->createReminderDto($row);
    }

    public function getReminder(): array
    {
        $pdo = new PDO('sqlite:' . __DIR__ . '/../../data/home-organisation.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->query("SELECT title, notes, due_at, repeat_rules, priority, status, created_at FROM reminder");
        $reminder = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $reminder;
    }

    public function getRemindersByRoomId(int $id): array
    {
        $pdo = new PDO('sqlite:' . __DIR__ . '/../../data/home-organisation.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare(
            "SELECT r.id, r.title, r.notes, r.due_at, r.repeat_rules, r.priority, r.status, r.created_at
             FROM reminder r
             INNER JOIN room_to_reminder rr ON rr.reminder_id = r.id
             WHERE rr.room_id = :id
             ORDER BY r.due_at"
        );
        $stmt->execute(['id' => $id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    private function createReminderDto(array $reminder): ReminderDto
    {
        return new ReminderDto(
            $reminder['users'],
            $reminder['rooms'],
            $reminder['title'],
            $reminder['notes'],
            $reminder['due_at'],
            $reminder['repeat_rules'],
            $reminder['priority'],
            $reminder['status'],
            $reminder['created_at']
        );
    }
    public function deleteReminderbyId(int $id): bool{
        $pdo = new PDO('sqlite:' . __DIR__ . '/../../data/home-organisation.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("DELETE FROM reminder WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}

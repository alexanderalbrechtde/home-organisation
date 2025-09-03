<?php

namespace App\Services;

use Dtos\ReminderDto;
use PDO;

class ReminderService
{
    //noch anpassen
    public function __construct(private PDO $pdo)
    {
    }

    public function getRemindersByRoomId(int $id): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT r.id, r.title, r.notes, r.due_at, r.priority, r.status, r.created_at
             FROM reminder r
             INNER JOIN room_to_reminder rr ON rr.reminder_id = r.id
             WHERE rr.room_id = :id
             ORDER BY r.due_at"
        );
        $stmt->execute(['id' => $id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

   // private function createReminderDto(array $reminder): ReminderDto
   // {
   //     return new ReminderDto(
   //         $reminder['users'],
   //         $reminder['rooms'],
   //         $reminder['title'],
   //         $reminder['notes'],
   //         $reminder['due_at'],
   //         $reminder['priority'],
   //         $reminder['status'],
   //         $reminder['created_at']
   //     );
   // }

    public function deleteReminderbyId(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM reminder WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getReminder(int $limit = 3, bool $descending = true): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT r.id, r.title, r.notes, r.due_at, r.priority, r.status, r.created_at,
                    GROUP_CONCAT(DISTINCT ro.name) AS rooms
             FROM reminder r
             LEFT JOIN room_to_reminder rr ON rr.reminder_id = r.id
             LEFT JOIN room ro ON ro.id = rr.room_id
             WHERE r.due_at IS NOT NULL
             GROUP BY r.id
             ORDER BY r.due_at ASC
             LIMIT :limit"
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $reminders = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        if ($descending) {
            $reminders = array_reverse($reminders);
        }
        return $reminders;
    }

    //remaining = verbleibend
    //rechnet anhand der gesetzten Variable due_at die verbleibende Zeit aus
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
}
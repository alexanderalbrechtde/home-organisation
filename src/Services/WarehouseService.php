<?php

namespace App\Services;

use App\Dtos\ItemDto;
use PDO;

class WarehouseService
{
    public function __construct(private PDO $pdo)
    {
    }

    public function edit(
        int $userId,
        int $roomId,
        string $name,
        string $category,
        int $amount
    ): bool {
        if ($userId === null || $roomId === null || $name === null || $category === null || $amount === null) {
            return false;
        }


        $statement = $this->pdo->prepare(
            'INSERT INTO item (name, category, amount,  created_by, room_id)
             VALUES(:name, :category, :amount,  :created_by, :room_id)
             ON CONFLICT(name, category)
             DO UPDATE SET amount = item.amount + excluded.amount'
        );
        $statement->execute([
            ':name' => $name,
            ':category' => $category,
            ':amount' => $amount,
            ':created_by' => $userId,
            ':room_id' => $roomId
        ]);

        $itemId = $this->pdo->lastInsertId();
        $statement = $this->pdo->prepare(
            'INSERT INTO item_to_user(item_id, user_id) 
                    VALUES(:item_id, :user_id)'
        );
        $statement->execute([
            ':item_id' => $itemId,
            ':user_id' => $userId,
        ]);

        $statement2 = $this->pdo->prepare(
            'INSERT INTO item_to_room(item_id, room_id)
                    VALUES(:item_id, :room_id)'
        );
        $statement2->execute([
            ':item_id' => $itemId,
            ':room_id' => $roomId,
        ]);

        return true;
    }

    public function getItems(): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT i.name, i.category, i.amount, r.name AS room_name
               FROM item i
               LEFT JOIN room r ON r.id = i.room_id
           ORDER BY i.name COLLATE NOCASE, i.category COLLATE NOCASE"
        );
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getRoomNames($userId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT name, id
         FROM room
         WHERE created_by = :user_id;"
        );

        $stmt->execute([':user_id' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

}
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
        int $amount,
        //string $room_name,
    ): bool {
        if ($name === '' || $category === '' || !is_numeric($amount) || filter_var(
                $amount,
                FILTER_VALIDATE_INT
            ) === false) {
            return false;
        }
        $amount = (int)$amount;


        $statement = $this->pdo->prepare(
            'INSERT INTO item (name, category, amount,  created_by, created_for)
             VALUES(:name, :category, :amount,  :created_by, :created_for)
             ON CONFLICT(name, category)
             DO UPDATE SET amount = item.amount + excluded.amount'
        );
        $statement->execute([
            ':name' => $name,
            ':category' => $category,
            ':amount' => $amount,
            /*':room_name' => $room_name,*/
            ':created_by' => $userId,
            ':created_for' => $roomId
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
               LEFT JOIN room r ON r.id = i.created_for
           ORDER BY i.name COLLATE NOCASE, i.category COLLATE NOCASE"
        );
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getRoomNames(int $userId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT room.id AS id, room.name AS name
             FROM room 
             WHERE created_by = :userId
             ORDER BY room.name COLLATE NOCASE"
        );
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

}
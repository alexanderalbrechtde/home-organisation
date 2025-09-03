<?php

namespace App\Services;

use PDO;

class RoomsCreateService
{
    public function __construct(private PDO $pdo){

    }
    function create(int $userId, string $name, string $description)
    {
        if (empty($userId) || empty($name) || empty($description)) {
            return false;
        }

        $statement = $this->pdo->prepare(
            'INSERT INTO room (created_by, name, description) VALUES (:created_by, :name, :description)'
        );
        $statement->execute([
            'created_by' => $userId,
            'name' => $name,
            'description' => $description
        ]);

        $roomId = $this->pdo->lastInsertId();

        $statement = $this->pdo->prepare(
            'INSERT INTO user_to_room (owner_user_id, room_id) VALUES (:owner_user_id, :room_id)'
        );
        $statement->execute([
            'owner_user_id' => $userId,
            'room_id' => $roomId,
        ]);

        return true;
    }
}
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
            'INSERT INTO room (id, name, description) VALUES (:id, :name, :description)'
        );
        $statement->execute([
            'id' => $userId,
            'name' => $name,
            'description' => $description
        ]);

        $roomId = $this->pdo->lastInsertId();

        $statement = $this->pdo->prepare(
            'INSERT INTO user_to_room (owner_user_id, room_id) VALUES (:owner_id, :room_id)'
        );
        $statement->execute([
            'owner_id' => $userId,
            'room_id' => $roomId,
        ]);

        return true;
    }
}
<?php

class RoomsCreateService
{
    function create(int $userId, string $name, string $description)
    {
        if (empty($userId) || empty($name) || empty($description)) {
            return false;
        }

        $pdo = new PDO('sqlite:' . __DIR__ . '/../../data/home-organisation.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $statement = $pdo->prepare(
            'INSERT INTO room (created_by, name, description) VALUES (:created_by, :name, :description)'
        );
        $statement->execute([
            'created_by' => $userId,
            'name' => $name,
            'description' => $description
        ]);

        $roomId = $pdo->lastInsertId();

        $statement =$pdo->prepare(
          'INSERT INTO user_to_room (owner_user_id, room_id) VALUES (:owner_user_id, :room_id)'
        );
        $statement->execute([
            'owner_user_id' => $userId,
            'room_id' => $roomId,
        ]);

        return true;
    }
}
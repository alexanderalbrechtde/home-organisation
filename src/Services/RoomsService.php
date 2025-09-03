<?php

namespace App\Services;

use App\Dtos\RoomDto;
use PDO;

class RoomsService
{
    public function __construct(private PDO $pdo)
    {
    }

    public function getRoombyName(string $name): ?RoomDto
    {
        $stmt = $this->pdo->prepare(
            'SELECT name, description  FROM room WHERE name = :name LIMIT 1'
        );
        $stmt->execute(['name' => $name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->createRoomDto($row);
    }

    public function getRooms(): array
    {
        $stmt = $this->pdo->query('SELECT  id, name, description FROM room');
        $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rooms;
    }

    private function createRoomDto(array $room): RoomDto
    {
        return new RoomDto(
            $room['users'],
            $room['name'],
            $room['description']
        );
    }

    public function getRoom(int $id): ?array
    {
        $stmt = $this->pdo->query('SELECT  id, name, description FROM room WHERE id = ' . $id . ' LIMIT 1');
        $room = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$room) {
            return null;
        }

        return $room;
    }
}
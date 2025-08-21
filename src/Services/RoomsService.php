<?php

class RoomsService
{
    public function getRoombyName(string $name): ?RoomDto
    {
        $pdo = new PDO('sqlite:' . __DIR__ . '/../../data/home-organisation.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare(
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
        $pdo = new PDO('sqlite:' . __DIR__ . '/../../data/home-organisation.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->query('SELECT  id, name, description FROM room');
        $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rooms;
    }

    private function createRoomDto(array $room): RoomDto
    {
        return new RoomDto(
            $room['name'],
            $room['description']
        );
    }

    public function getRoom(int $id): ?array
    {
        $pdo = new PDO('sqlite:' . __DIR__ . '/../../data/home-organisation.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->query('SELECT  id, name, description FROM room WHERE id = ' . $id . ' LIMIT 1');
        $room = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$room) {
            return null;
        }

        return $room;
    }
}
<?php

namespace App\Services;

use App\Dtos\RoomDto;
use App\Entities\RoomEntity;
use Framework\Services\OrmService;
use PDO;

class RoomsService
{
    public function __construct(private PDO $pdo, private OrmService $ormService)
    {
    }

    public function getRooms(int $userId): array
    {
        $rooms = $this->ormService->findBy(
            [
                'user_id' => $userId
            ],
            RoomEntity::class
        );
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
        $stmt = $this->pdo->query(
            '
        SELECT  id, name, description 
        FROM room 
        WHERE id = ' . $id . ' LIMIT 1'
        );
        $room = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$room) {
            return null;
        }

        return $room;
    }
}
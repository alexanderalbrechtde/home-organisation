<?php

readonly class RoomDto
{
    //__construct = Objekt initialisieren
    /**
     * @param array<UserDto> $users
     */
    public function __construct(
        public array $users,
        public string $name,
        public string $description,
    ) {
    }
}
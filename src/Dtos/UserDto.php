<?php
//user transfer object

namespace App\Dtos;

readonly class UserDto
{
    //__construct = Objekt initialisieren
    public function __construct(
        public int $id,
        public string $first_name,
        public string $last_name,
        public string $email,
        public string $password,
    ) {
    }
}
<?php
//user transfer object
readonly class UserDto
{
    //__construct = Objekt initialisieren
    public function __construct(
        public int $id,
        public string $first_Name,
        public string $last_Name,
        public string $email,
        public string $password,
    ) {
    }
}
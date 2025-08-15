<?php
//user transfer object
namespace Dtos;

readonly class UserDto
{
    //__construct = Objekt initialisieren
    public function __construct(
        public string $first_Name,
        public string $last_Name,
        public string $email,
        public string $password,
        public string $username,
    ) {
    }
}
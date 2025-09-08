<?php

namespace App\Dtos;


readonly class ItemDto
{
    public function __construct(
        public array $users,
        public array $rooms,
        public string $name,
        public string $category,
        public int $amount
    ) {
    }
}
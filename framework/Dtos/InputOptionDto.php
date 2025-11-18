<?php

namespace Framework\Dtos;

class InputOptionDto
{
    public function __construct(
        public string $name,
        public string $description,
        public ?string $value = null,
        public ?string $alias = null,
        public ?string $default = null
    ) {
    }
}
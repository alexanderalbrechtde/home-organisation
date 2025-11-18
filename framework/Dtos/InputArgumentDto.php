<?php

namespace Framework\Dtos;

class InputArgumentDto
{
    public function __construct(
        public string $name,
        public string $description,
        public bool $required = true,
    ) {
    }
}
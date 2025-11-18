<?php

namespace Framework\Dtos;

class DirectoryLocationDto
{
    public function __construct(
        public string $path,
        public string $nameSpace,
    ) {
    }
}
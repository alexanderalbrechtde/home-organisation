<?php

namespace Framework\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
readonly class OrmColumn
{
    public function __construct(
        public string $columnName
    ) {
    }
}
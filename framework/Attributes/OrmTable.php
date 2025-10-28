<?php

namespace Framework\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
readonly class OrmTable
{
    public function __construct(public string $tableName
    ) {
    }
}
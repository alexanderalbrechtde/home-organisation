<?php

namespace Framework\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
readonly class OrmId
{
    public function __construct()
    {
    }
}
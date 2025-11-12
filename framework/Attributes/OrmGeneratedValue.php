<?php

namespace Framework\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
readonly class OrmGeneratedValue
{
    public function __construct()
    {
    }
}
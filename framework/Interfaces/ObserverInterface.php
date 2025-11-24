<?php

namespace Framework\Interfaces;

interface ObserverInterface
{
    public function run(object $observable): void;
}
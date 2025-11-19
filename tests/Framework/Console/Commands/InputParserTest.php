<?php

namespace Test\Framework\Console\Commands;

use Framework\Console\InputParser;
use PHPUnit\Framework\TestCase;

class InputParserTest extends TestCase
{
    public function testParse()
    {
        $arguments = [];
        $input = new InputParser();

        $input->parse($arguments);


    }
}
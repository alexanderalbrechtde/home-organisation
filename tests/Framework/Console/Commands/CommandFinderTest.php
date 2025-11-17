<?php

namespace Test\Framework\Console\Commands;

use Framework\Console\CommandFinder;
use PHPUnit\Framework\TestCase;

class CommandFinderTest extends TestCase
{
    public function testGetClassName(): void
    {
        $finder = new CommandFinder();

        $path = __DIR__ . '/../../src/Console/MyCommand.php';
        $directory = realpath(__DIR__ . '/../../src/Console');
        $namespace = 'Framework\\Console';

        $expected = 'App\\Console\\MyCommand';
        $result = $finder->getClassName($path, $directory, $namespace);

        $this->assertNotEquals($expected, $result);
    }
}
<?php

namespace Test\Framework\Console\Commands;

use Framework\Console\Output;
use Framework\Dtos\InputArgumentDto;
use Framework\Dtos\InputDefinitionDto;
use Framework\Enums\ExitCode;
use Framework\Interfaces\CommandInterface;

class TestCommand implements CommandInterface
{

    public static function name(): string
    {
        return 'fake';
    }

    public function getDefinition(): InputDefinitionDto
    {
        return new InputDefinitionDto([
            new InputArgumentDto()
        ]);
    }

    public function __invoke(Output $output): ExitCode
    {
        $output->writeLine('Das ist ein Test!');
        $output->writeNewLine();

        return ExitCode::Success;
    }

    public static function description(): string
    {
        // TODO: Implement description() method.
    }
}
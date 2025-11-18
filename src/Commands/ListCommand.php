<?php

namespace App\Commands;

use Framework\Console\CommandFinder;
use Framework\Console\Input;
use Framework\Console\Output;
use Framework\Dtos\DirectoryLocationDto;
use Framework\Dtos\InputArgumentDto;
use Framework\Dtos\InputDefinitionDto;
use Framework\Dtos\InputOptionDto;
use Framework\Enums\ExitCode;
use Framework\Interfaces\CommandInterface;

class ListCommand implements CommandInterface
{

    public array $commands = [];


    public static function name(): string
    {
        return 'list';
    }

    public function __invoke(Input $input, Output $output): ExitCode
    {
        $output->writeLine('Alle verfügbaren Commands:');
        $output->writeNewLine();

        $finder = new CommandFinder();
        $this->commands = $finder->find(
            [
                new DirectoryLocationDto(__DIR__ . '/../../src', 'App'),
                new DirectoryLocationDto(__DIR__ . '/../../src', 'Framework')
            ]
        );

        $commands = array_keys($this->commands);
        //dd($commands);

        foreach ($commands as $commandName) {
            $output->writeLine(" - " . $commandName . "  =>\t" . $this->commands[$commandName]['description']);
            $output->writeNewLine();
        }

        return ExitCode::Success;
    }

    public function getDefinition(): InputDefinitionDto
    {
        return new InputDefinitionDto()->addArgument(
            new InputArgumentDto(
                'list',
                'a list of all commands',
                true
            )
        )
            ->addOption(
                new InputOptionDto(
                    'test2',
                    'another test',
                    null,
                    'list',
                    null
                )
            );
    }

    public static function description(): string
    {
        return 'a list of all commands';
    }
}
<?php

namespace App\Commands;

use Framework\Console\CommandFinder;
use Framework\Console\Output;
use Framework\Enums\ExitCode;
use Framework\Interfaces\CommandInterface;

class ListCommand implements CommandInterface
{

    public array $commands = [];


    public static function name(): string
    {
        return 'list';
    }

    public function __invoke(Output $output): ExitCode
    {
        $output->writeLine('Alle verfügbaren Commands:');
        $output->writeNewLine();

        $finder = new CommandFinder();
        $this->commands = $finder->find(__DIR__ . '/../../src', 'App');

        foreach($this->commands as $name => $value){
            $output->writeLine(" - " . $name);
            $output->writeNewLine();

        }

        return ExitCode::Success;
    }
}
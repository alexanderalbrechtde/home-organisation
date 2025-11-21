<?php

namespace Framework\Console;

use Framework\Dtos\DirectoryLocationDto;
use Framework\Enums\ExitCode;

class ConsoleApplication
{
    public array $commands = [] ?? null;

    public function boot(DirectoryLocationDto ...$directories): self
    {
        $finder = new CommandFinder();
        $this->commands = $finder->find($directories);
        //dd($this->commands);

        return $this;
    }

    public function run(array $arguments): ExitCode
    {
        $output = new Output();
        $inputParser = new InputParser();
        //dd($this->commands);
        $command = new $this->commands[$inputParser->commandName]['path'];

        $definition = $command->getDefinition();

        $input = $inputParser->parse($arguments, $definition);
        $commandName = $input->getCommandName();

        if (!$commandName) {
            $output->writeLine("Fehler: Kein Befehl angegeben.");
            $output->writeNewLine();
            return ExitCode::Error;
        }

        if (!isset($this->commands[$commandName])) {
            $output->writeLine("Fehler: Befehl '$commandName' nicht gefunden.");
            $output->writeNewLine();
            return ExitCode::Error;
        }

        $command = new $this->commands[$commandName]['path'];
        //Command hat Interface: ja, dann ConsoleAppication mitgeben

        return $command($input, $output);
    }
}
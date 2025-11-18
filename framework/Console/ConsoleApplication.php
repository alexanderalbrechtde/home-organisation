<?php

namespace Framework\Console;

use Framework\Dtos\DirectoryLocationDto;
use Framework\Enums\ExitCode;
use Framework\Interfaces\CommandInterface;

class ConsoleApplication
{
    public array $commands = [] ?? null;

    public function boot(DirectoryLocationDto ...$directories): self
    {
        $finder = new CommandFinder();
        $this->commands = $finder->find($directories);

        return $this;
    }

    public function run(array $arguments): ExitCode
    {
        $output = new Output();
        $inputParser = new InputParser();

        $input = $inputParser->parse($arguments);
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

        return $command($input, $output);
    }
}
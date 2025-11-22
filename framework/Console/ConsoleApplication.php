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

        return $this;
    }

    public function run(array $arguments): ExitCode
    {
        $output = new Output();
        $inputParser = new InputParser();

        if (in_array('--help', $inputParser->parameters) || in_array('-h', $inputParser->parameters)) {
            return $this->showHelp($inputParser->commandName, $output);
        }

        $command = new $this->commands[$inputParser->commandName]['path'];

        $definition = $command->getDefinition();

        $input = $inputParser->parse($arguments, $definition);
        $commandName = $input->getCommandName();

        $command = new $this->commands[$commandName]['path'];

        return $command($input, $output);
    }

    private function showHelp(string $commandName, Output $output): ExitCode
    {
        if (!$commandName) {
            $output->writeLine("Fehler: Kein Befehl angegeben.");
            $output->writeNewLine();
            return ExitCode::Error;
        }

        if (!isset($this->commands[$commandName])) {
            $output->writeLine("Fehler: Command '$commandName' nicht gefunden.");
            $output->writeNewLine();
            return ExitCode::Error;
        }

        $output->writeLine("Command: " . $commandName);
        $output->writeNewLine();
        $output->writeLine("Beschreibung: " . $this->commands[$commandName]['description']);
        $output->writeNewLine();

        return ExitCode::Success;
    }
}
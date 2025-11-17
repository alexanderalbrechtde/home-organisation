<?php

namespace Framework\Console;

use Framework\Enums\ExitCode;
use Framework\Interfaces\CommandInterface;

class ConsoleApplication
{

    public array $commands = [] ?? null;


    /**
     * @param class-string<CommandInterface> $command
     * @return void
     */
    public function add(string $command): void
    {
        $this->commands[$command::name()] = $command;
    }

    public function boot(string $directory, string $nameSpace): self
    {
        $finder = new CommandFinder();
        $this->commands = $finder->find(__DIR__ . '/../../src', 'App');

        return $this;
    }

    public function run(): ExitCode
    {
        $output = new Output();
        $commandName = $_SERVER['argv'][1] ?? null;
        //dd($commandName);


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

        $command = new $this->commands[$commandName]($this->commands);
        return $command($output);
    }
}
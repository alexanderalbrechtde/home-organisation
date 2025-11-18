<?php

namespace Framework\Console;

use Framework\Dtos\InputArgumentDto;
use Framework\Dtos\InputOptionDto;

class Input
{
    public string $commandName;

    /** @var array <string, InputArgumentDto> $arguments */
    public array $arguments;

    /** @var array <string, InputOptionDto> $arguments */
    private array $options;

    public function getCommandName(): string
    {
        return $this->commandName;
    }

    /**
     * @return array<string, <InputArgumentDto>
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @return array<string, InputOptionDto>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    public function setArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function setCommandName(string $commandName): void
    {
        $this->commandName = $commandName;
    }
}
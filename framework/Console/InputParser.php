<?php

namespace Framework\Console;

use Framework\Dtos\InputArgumentDto;
use Framework\Dtos\InputDefinitionDto;
use Framework\Dtos\InputOptionDto;

class  InputParser
{
    public string $commandName;
    public array $parameters;

    public function __construct()
    {
        $argument = $_SERVER['argv'];
        array_shift($argument);

        $this->commandName = array_shift($argument);
        $this->parameters = $argument;
    }

    public function parse(array $arguments, InputDefinitionDto $definition): Input
    {
        $input = new Input;

        foreach ($arguments as $argument) {
            if (str_starts_with($argument, '--')) {
                $name = substr($argument, 2);
            } elseif (str_starts_with($argument, '-')) {
                $name = substr($argument, 1);
            }
            if (str_contains($argument, '=')) {
                [$name, $val] = explode('=', $name, 2);
                foreach ($definition->options as $option) {
                    if ($option->name === $name) {
                        $option->value = $val;
                        $input->setOptions($option);
                    } else {
                        dd('Option nicht gefunden!');
                    }
                }
                continue;
            }
            foreach ($definition->arguments as $value) {
                if ($value->name === $argument) {
                    $input->setArguments($value);
                }
            }
        }
        $input->setCommandName($this->commandName);

        return $input;
    }
}
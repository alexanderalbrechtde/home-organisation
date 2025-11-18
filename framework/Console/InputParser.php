<?php

namespace Framework\Console;

use Framework\Dtos\InputArgumentDto;
use Framework\Dtos\InputOptionDto;
use http\Exception\RuntimeException;

class  InputParser
{

    public function parse(array $arguments): Input
    {
        array_shift($arguments);
        $commandName = array_shift($arguments);

        if (!$commandName) {
            throw new RuntimeException("Kein Befehl angegeben");
        }

        $inputArguments = [];
        $options = [];

        foreach ($arguments as $argument) {
            //Option
            if (str_starts_with($argument, '--')) {
                $name = substr($argument, 2);
                if (str_contains($argument, '=')) {
                    [$name, $val] = explode('=', $name, 2);
                } else {
                    $val = 'true';
                }

                $options[$name] = new InputOptionDto(
                    $name,
                    '',
                    $val,
                    null,
                    null
                );
            } //Aliasoption
            elseif (str_starts_with($argument, '-')) {
                $name = substr($argument, 1);
                if (str_contains($argument, '=')) {
                    [$name, $val] = explode('=', $name, 2);
                } else {
                    $val = 'true';
                }

                $options[$name] = new InputOptionDto(
                    $name,
                    '',
                    $val,
                    $name,
                    null
                );
            } //Argument
            else {
                $inputArguments[$argument] = new InputArgumentDto(
                    $argument,
                    '',
                    true
                );
            }
        }
        $input = new Input();
        $input->setCommandName($commandName);
        $input->setArguments($inputArguments);
        $input->setOptions($options);

        return $input;
    }

}
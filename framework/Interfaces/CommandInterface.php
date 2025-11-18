<?php

namespace Framework\Interfaces;

//name, Aliase
//execute MEthode
//alle BEfehle brauche invoke

use Framework\Console\Input;
use Framework\Console\Output;
use Framework\Dtos\InputDefinitionDto;
use Framework\Enums\ExitCode;

interface CommandInterface
{
    public static function name(): string;
    public static function description(): string;

    public function getDefinition(): InputDefinitionDto;

    public function __invoke(Input $input, Output $output): ExitCode;

}
<?php

namespace Framework\Console\Commands;

use Framework\Console\Input;
use Framework\Console\Output;
use Framework\Dtos\InputArgumentDto;
use Framework\Dtos\InputDefinitionDto;
use Framework\Dtos\InputOptionDto;
use Framework\Enums\ExitCode;
use Framework\Interfaces\CommandInterface;

class ShowAllDataCommand implements CommandInterface
{

    public static function name(): string
    {
        return 'showAll';
    }

    public static function description(): string
    {
        return 'show all Data in Location';
    }

    public function getDefinition(): InputDefinitionDto
    {
        return new InputDefinitionDto()->addArgument(
            new InputArgumentDto(
                'show',
                'show Data',
                true
            )
        )
            ->addOption(
                new InputOptionDto(
                    'framework',
                    'framework data',
                    null,
                    '-sf',
                    null
                )
            )
            ->addOption(
                new InputOptionDto(
                    'app',
                    'app data',
                    null,
                    '-af',
                    null
                )
            );
    }

    public function __invoke(Input $input, Output $output): ExitCode
    {
        // TODO: Implement __invoke() method.
    }
}
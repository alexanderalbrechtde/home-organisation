<?php

namespace App\Commands;

use Framework\Console\CommandFinder;
use Framework\Console\Input;
use Framework\Console\Output;
use Framework\Dtos\DirectoryLocationDto;
use Framework\Dtos\InputArgumentDto;
use Framework\Dtos\InputDefinitionDto;
use Framework\Dtos\InputOptionDto;
use Framework\Enums\ExitCode;
use Framework\Interfaces\CommandInterface;

class knockingOffCommand implements CommandInterface
{

    public static function name(): string
    {
        return 'knockOff';
    }

    public static function description(): string
    {
        return 'time';
    }

    public function getDefinition(): InputDefinitionDto
    {
        return new InputDefinitionDto()
            ->addOption(
                new InputOptionDto(
                    'show',
                    'show the option you select',
                    null,
                    '-t',
                    null
                )
            );
    }

    public function __invoke(Input $input, Output $output): ExitCode
    {
        $output->writeLine('-- Time --');
        $output->writeNewLine();

        $options = $input->getOptions() ?? null;
        $filter = $options[0] ?? null;
        $filterValue = $filter->value ?? null;

        //now
        $now[] = time();
        //workStart = '7:30';
        $workStart[] = strtotime('07:45');
        $workEnd[] = strtotime('16:15'); //


        //until
        $untilStart = $now[0] - $workStart[0];
        $untilHoures = floor($untilStart / 3600);
        $untilMinutes = floor(($untilStart % 3600) / 60);

        //remaing
        $remaining = $workEnd[0] - $now[0];
        $restHoures = floor($remaining / 3600);
        $restMinutes = floor(floor($remaining % 3600) / 60);


        $return_value = match ($filterValue) {
            'past' => [$untilHoures, $untilMinutes],
            'remaining' => [$restHoures, $restMinutes],
            'now' => $now
        };

        if ($filterValue == 'past') {
            $output->writeLine(
                "Du bist schon seit $return_value[0] Stunden und $return_value[1] Minuten auf der Arbeit."
            );
            $output->writeNewLine();
        } elseif ($filterValue == 'remaining') {
            $output->writeLine(
                "Es verbleiben noch $return_value[0] Stunden und $return_value[1] Minuten auf der Arbeit."
            );
            $output->writeNewLine();
        } else {
            $output->writeLine("Aktuelle Zeit: " . date('H:i:s', $return_value[0]));
        }
        $output->writeNewLine();

        return ExitCode::Success;
    }
}
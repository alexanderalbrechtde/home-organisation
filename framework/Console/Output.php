<?php

namespace Framework\Console;

use Framework\Enums\Color;
use Framework\Enums\Location;

class Output
{
    //helperklasse fürs Lienienschreiben
    //Ausgabe echo
    //Auch hier Text schöner machen und vorgenerierte Code

    public function writeLine($message)
    {
        //Ausgabe in einer Zeile
        echo $message;
    }

    public function writeNewLine()
    {
        //Ausgabe auf neuer Zeile
        echo "\n";
    }

    public function textFormat(Color $color): void
    {
        echo "\e[" . $color->value . 'm';
    }

    public function getLocation(Location $location): void
    {
        echo "$location->name";
    }

}
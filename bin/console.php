<?php

use Framework\Console\ConsoleApplication;
use Framework\Dtos\DirectoryLocationDto;

require_once __DIR__ . '/../vendor/autoload.php';

$appDto = new DirectoryLocationDto(__DIR__ . '/../src', 'App');
$frameworkDto = new DirectoryLocationDto(__DIR__ . '/../src', 'Framework');

$console = new ConsoleApplication()->boot($appDto, $frameworkDto)->run($_SERVER['argv']);

exit($console->value);
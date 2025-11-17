<?php

namespace Framework\Console;

use Framework\Interfaces\CommandInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class CommandFinder
{
    public function find(string $directory, string $nameSpace): array
    {
        $commandClasses = [];

        //dd($directory);

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

        /** @var SplFileInfo $file */
        foreach ($iterator as $file) {
            if (!$file->isFile()) {
                continue;
            }
            $class = $this->getClassName($file->getRealPath(), $directory);
            //dd($class);
            if ($this->isValidCommand($class)) {
                $commandClasses[$class::name()] = $class;
            }
        }

        //dd($commandClasses);
        //exit;
        return $commandClasses;
    }

    public function getClassName(string $path, string $directory): string
    {
        $relativePath = substr($path, strlen(realpath($directory)));
        $relativePath = 'App' . $relativePath;
        $relativePath = str_replace($directory, '', $relativePath);
        $relativePath = str_replace('.php', '', $relativePath);
        $relativePath = str_replace('/', '\\', $relativePath);
        return $relativePath;
    }

    private function isValidCommand(string $class): bool
    {
        if (!$class || !class_exists($class)) {
            return false;
        }
        return is_subclass_of($class, CommandInterface::class);
    }

}
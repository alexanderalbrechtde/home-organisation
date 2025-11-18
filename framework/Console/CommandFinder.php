<?php

namespace Framework\Console;

use Framework\Dtos\DirectoryLocationDto;
use Framework\Interfaces\CommandInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class CommandFinder
{
    /**
     * @param DirectoryLocationDto[] $directories
     * @return array
     */
    public function find(array $directories): array
    {
        $commandClasses = [];

        foreach ($directories as $directory) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory->path));

            /** @var SplFileInfo $file */
            foreach ($iterator as $file) {
                if (!$file->isFile()) {
                    continue;
                }
                /** @var class-string<CommandInterface> $class */
                $class = $this->getClassName($file->getRealPath(), $directory->path, $directory->nameSpace);
                if ($this->isValidCommand($class)) {
                    $commandClasses[$class::name()] = [
                        'path' => $class,
                        'description' => $class::description()
                    ];
                }
            }
        }

        return $commandClasses;
    }

    public function getClassName(string $path, string $directory, string $nameSpace): string
    {
        $relativePath = substr($path, strlen(realpath($directory)));
        $relativePath = $nameSpace . $relativePath;
        $relativePath = str_replace($directory, '', $relativePath);
        $relativePath = str_replace('.php', '', $relativePath);
        $relativePath = str_replace('/', '\\', $relativePath);

        return $relativePath;
    }

    public function isValidCommand(string $class): bool
    {
        if (!$class || !class_exists($class)) {
            return false;
        }
        return is_subclass_of($class, CommandInterface::class);
    }

}
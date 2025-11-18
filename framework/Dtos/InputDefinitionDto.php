<?php

namespace Framework\Dtos;

class InputDefinitionDto
{
    public function __construct(
        public array $arguments = [],
        public array $options = []
    ) {
    }

    public function addArgument(InputArgumentDto $argument): self
    {
        $this->arguments[] = $argument;
        return $this;
    }

    public function addOption(InputOptionDto $option): self
    {
        $this->options[] = $option;
        return $this;
    }
}
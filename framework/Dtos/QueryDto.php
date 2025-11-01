<?php

namespace Framework\Dtos;

//DTO = Data Trnasfer Object
class QueryDto
{
    public function __construct(public string $query, public array $parameters)
    {
    }


}
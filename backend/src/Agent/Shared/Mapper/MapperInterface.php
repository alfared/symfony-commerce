<?php

namespace App\Agent\Shared\Mapper;

interface MapperInterface
{
    public function toArray(object $object): array;

    public function manyToArray(array $objects): array;
}
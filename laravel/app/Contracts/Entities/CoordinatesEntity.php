<?php

namespace App\Contracts\Entities;

readonly class CoordinatesEntity
{
    public function __construct(
        public string $longitude,
        public string $latitude,
    ) {}
}
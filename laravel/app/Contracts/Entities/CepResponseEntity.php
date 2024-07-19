<?php

namespace App\Contracts\Entities;

readonly class CepResponseEntity
{
    public function __construct(
        public string $cep,
        public string $state,
        public string $city,
        public string $neighborhood,
        public string $street,
        public CoordinatesEntity $coordinates,
    ) {}
}
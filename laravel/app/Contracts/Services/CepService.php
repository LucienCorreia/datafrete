<?php

namespace App\Contracts\Services;

use App\Contracts\Entities\CepResponseEntity;
use App\Contracts\Entities\CoordinatesEntity;

interface CepService
{
    public function getCep(string $cep): CepResponseEntity;

    public function distancia(CoordinatesEntity $origem, CoordinatesEntity $destino): float;
}

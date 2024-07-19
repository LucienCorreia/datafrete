<?php

namespace App\Exepctions;

use Exception;

class CepNaoRetornaCoordenadasException extends Exception
{
    public function __construct(string $cep)
    {
        parent::__construct("O CEP $cep não retorna coordenadas");
    }
}
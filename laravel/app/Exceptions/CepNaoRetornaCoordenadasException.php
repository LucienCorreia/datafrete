<?php

namespace App\Exceptions;

use Exception;

class CepNaoRetornaCoordenadasException extends Exception
{
    public function __construct(public string $cep)
    {
        parent::__construct("O CEP $cep não retorna coordenadas");
    }
}
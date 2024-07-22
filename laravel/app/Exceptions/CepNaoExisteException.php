<?php

namespace App\Exceptions;

use Exception;

class CepNaoExisteException extends Exception
{
    public function __construct(public string $cep)
    {
        parent::__construct("O CEP $cep não existe");
    }
}
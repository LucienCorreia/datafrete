<?php

namespace App\Exepctions;

use Exception;

class CepNaoExisteException extends Exception
{
    public function __construct(string $cep)
    {
        parent::__construct("O CEP $cep não existe");
    }
}
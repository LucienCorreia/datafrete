<?php

namespace App\Services;

use App\Contracts\Entities\CepResponseEntity;
use App\Contracts\Services\CepService as CepServiceContract;
use App\Contracts\Repositories\CepRepository as CepRepositoryContract;
use GuzzleHttp\Client;
use App\Contracts\Entities\CoordinatesEntity;
use App\Exepctions\CepNaoRetornaCoordenadasException;
use App\Exepctions\CepNaoExisteException;

class CepService implements CepServiceContract
{
    private Client $http;

    public function __construct(
    ) {
        $this->http = new Client([
            'base_uri' => 'https://brasilapi.com.br/api/cep/v2/',
        ]);
    }

    public function getCep(string $cep): CepResponseEntity
    {
        try {
            $result = $this->http->request('GET', $cep);
            $data = json_decode($result->getBody()->getContents(), true);

            if (empty($data['location']['coordinates'])) {
                throw new CepNaoRetornaCoordenadasException($cep);
            }

            $entity = new CepResponseEntity(
                $data['cep'],
                $data['state'],
                $data['city'],
                $data['neighborhood'],
                $data['street'],
                new CoordinatesEntity($data['location']['coordinates']['latitude'], $data['location']['coordinates']['longitude']),
            );
            return $entity;
        } catch (\Exception $e) {
            throw new CepNaoExisteException($cep);
        }
    }

    public function distancia(CoordinatesEntity $origem, CoordinatesEntity $destino): float
    {
        $r = 6371; // Raio da Terra em km

        $dLat = deg2rad($destino->latitude - $origem->latitude);
        $dLon = deg2rad($destino->longitude - $origem->longitude);
    
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($origem->latitude)) * cos(deg2rad($destino->latitude)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));
    
        return $r * $c;
    }
}

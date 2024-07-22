<?php
 
namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use App\Models\Registro;
use App\Contracts\Services\CepService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
 
class ImportarRegistrosAsyncJob implements ShouldQueue
{
    use Queueable;

    public $tries = 3;

    public $maxExceptions = 10;

    public $backoff = 60;
 
    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $dados,
    ) {}
 
    /**
     * Execute the job.
     */
    public function handle(CepService $cepService): void
    {
        try {
            $checkJaFoiCalculado = Registro::where(function($query) {
                $query->where('origem', $this->dados[0])
                    ->where('destino', $this->dados[1]);
            })->orWhere(function($query) {
                $query->where('origem', $this->dados[1])
                    ->where('destino', $this->dados[0]);
            })->count();

            if ($checkJaFoiCalculado > 0) {
                return;
            }

            $cacheCepInvalidoOrigem = Cache::get('cep_invalido-'.$this->dados[0], false);
            $cacheCepInvalidoDestino = Cache::get('cep_invalido-'.$this->dados[0], false);

            if ($cacheCepInvalidoOrigem === true || $cacheCepInvalidoDestino === true) {
                return;
            }

            $cepOrigem = Cache::get($this->dados[0], false);
            $cepDestino = Cache::get($this->dados[1], false);

            if ($cepOrigem === false) {
                $cepOrigem = $cepService->getCep($this->dados[0]);
            }
            
            if ($cepDestino === false) {
                $cepDestino = $cepService->getCep($this->dados[1]);
            }

            $distancia = $cepService->distancia($cepOrigem->coordinates, $cepDestino->coordinates);

            Registro::create([
                'origem' => $this->dados[0],
                'destino' => $this->dados[1],
                'distancia' => $distancia,
            ]);

            Cache::forever($this->dados[0], $cepOrigem);
            Cache::forever($this->dados[1], $cepDestino);
        } catch (\App\Exceptions\CepNaoExisteException $e) {
            Cache::forever('cep_invalido-'.$e->cep, true);
            return;
        } catch (\App\Exceptions\CepNaoRetornaCoordenadasException $e) {
            Cache::forever('cep_invalido-'.$e->cep, true);
            return;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
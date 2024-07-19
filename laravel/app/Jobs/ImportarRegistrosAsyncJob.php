<?php
 
namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use App\Models\Registro;
use App\Contracts\Services\CepService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Bus\Batchable;
use Illuminate\Support\Collection;
 
class ImportarRegistrosAsyncJob implements ShouldQueue
{
    use Queueable, Batchable;
 
    /**
     * Create a new job instance.
     */
    public function __construct(
        public Collection $dados,
    ) {}
 
    /**
     * Execute the job.
     */
    public function handle(CepService $cepService): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        foreach ($dados as $dado) {
            try {
                $cepOrigem = Cache::rememberForever($dado[0], function () use ($cepService) {
                    return $cepService->getCep($dado[0]);
                });
                $cepDestino = Cache::rememberForever($dado[1], function () use ($cepService) {
                    return $cepService->getCep($dado[1]);
                });
                $distancia = $cepService->distancia($cepOrigem->coordinates, $cepDestino->coordinates);
                Registro::create([
                    'origem' => $dado[0],
                    'destino' => $dado[1],
                    'distancia' => $distancia,
                ]);
            } catch (\Exception $e) {
            }
        }
    }
}
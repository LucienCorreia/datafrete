<?php
 
namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use App\Models\Registro;
use App\Contracts\Services\CepService;
use Illuminate\Support\Facades\Cache;
 
class ImportarRegistrosAsyncJob implements ShouldQueue
{
    use Queueable;
 
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
            $cepOrigem = Cache::rememberForever($this->dados[0], function () use ($cepService) {
                return $cepService->getCep($this->dados[0]);
            });
            $cepDestino = Cache::rememberForever($this->dados[1], function () use ($cepService) {
                return $cepService->getCep($this->dados[1]);
            });
            $distancia = $cepService->distancia($cepOrigem->coordinates, $cepDestino->coordinates);
            Registro::create([
                'origem' => $this->dados[0],
                'destino' => $this->dados[1],
                'distancia' => $distancia,
            ]);
        } catch (\Exception $e) {
        }
    }
}
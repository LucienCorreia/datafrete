<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\RegistroPostRequest;
use App\Http\Requests\RegistroPatchRequest;
use App\Http\Requests\RegistroImportarRequest;
use App\Contracts\Services\CepService;
use League\Csv\Reader;
use App\Jobs\ImportarRegistrosAsyncJob;

class RegistroController extends Controller
{
    public function index()
    {
        $registros = Registro::paginate();

        return view('modules.registros.index', ['registros' => $registros]);
    }

    public function create()
    {
        return view('modules.registros.create');
    }

    public function store(RegistroPostRequest $request, CepService $cepService)
    {
        try {
            $cepDestino = $cepService->getCep($request->destino);
            $cepOrigem = $cepService->getCep($request->origem);
        } catch (\Exception $e) {
            $request->session()->flash('error', $e->getMessage());
            return redirect()->back()->withInput();
        }

        $distancia = $cepService->distancia($cepOrigem->coordinates, $cepDestino->coordinates);
        $request->merge(['distancia' => $distancia]);

        $registro = Registro::create($request->all());

        $request->session()->flash('success', 'Os registros serão calculados e salvos em breve, aguarde um momento!');

        return redirect()->route('registros.index');
    }

    public function edit(Registro $registro)
    {
        return view('modules.registros.edit', ['registro' => $registro]);
    }

    public function update(RegistroPatchRequest $request, Registro $registro, CepService $cepService)
    {
        try {
            $cepDestino = $cepService->getCep($request->destino);
            $cepOrigem = $cepService->getCep($request->origem);
        } catch (\Exception $e) {
            $request->session()->flash('error', $e->getMessage());
            return redirect()->back()->withInput();
        }

        $distancia = $cepService->distancia($cepOrigem->coordinates, $cepDestino->coordinates);
        $request->merge(['distancia' => $distancia]);

        $registro->update($request->all());

        $registro->save();

        return redirect()->route('registros.index');
    }

    public function destroy(Registro $registro)
    {
        $registro->delete();

        return redirect()->route('registros.index');
    }

    public function importar(RegistroImportarRequest $request)
    {
        $file = $request->file('file');

        $csv = Reader::createFromPath($file->path(), 'r');
        $registros = $csv->getRecords();

        foreach ($registros as $key => $row) {
            dispatch(new ImportarRegistrosAsyncJob($row))->delay(now()->addSeconds((int) $key));
        }

        return redirect()->route('registros.index');
    }
}

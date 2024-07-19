@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Registros</div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table class="table">
                            <tr>
                                <th>Cep Origem</th>
                                <th>Cep Destino</th>
                                <th>Distância</th>
                                <th>Criado em</th>
                                <th>Atualizado em</th>
                                <th>Ações</th>
                            </tr>
                            @foreach($registros as $registro)
                                <tr>
                                    <td>{{ $registro->origem }}</td>
                                    <td>{{ $registro->destino }}</td>
                                    <td>{{ $registro->distancia }} km</td>
                                    <td>@datetime($registro->created_at)</td>
                                    <td>@datetime($registro->updated_at)</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-warning" href="{{ route('registros.edit', $registro->id) }}">Editar</a>
                                            <button type="button" class="btn btn-danger" onclick="event.preventDefault(); document.querySelector('form').submit();">Excluir</button>
                                        </div>
                                        <form id="delete-form-{{ $registro->id }}" method="POST" action="{{ route('registros.destroy', $registro->id) }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $registros->links() }}
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('registros.create') }}" class="btn btn-primary">Criar Registro</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
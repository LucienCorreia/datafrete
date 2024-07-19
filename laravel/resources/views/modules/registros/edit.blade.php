@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Atualizar Registro</div>
                    <form method="POST" action="{{ route('registros.update', $registro->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                            <div class="form-group">
                                <label for="origem">Cep Origem</label>
                                <input type="text" required minlength="8" maxlength="8" pattern="[0-9]{8}" class="form-control" id="origem" name="origem" placeholder="00000000" value="{{old('origem', $registro->origem)}}">
                            </div>
                            <div class="form-group">
                                <label for="destino">Cep Destino</label>
                                <input type="text" required minlength="8" maxlength="8" pattern="[0-9]{8}" class="form-control" id="destino" name="destino" placeholder="00000000" value="{{old('destino', $registro->destino)}}">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endSection
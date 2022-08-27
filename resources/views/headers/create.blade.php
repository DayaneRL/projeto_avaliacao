@extends('layouts.app')

@section('title')
    Cadastrar Cabeçalho
@endsection

@section('content')
    <div class="col-12 mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row mb-3">
                    <form action="{{route('headers.store')}}" method="POST" class="col-12">
                        @csrf
                        <div class="form-row mb-2">
                            <div class="form-group col-md-12">
                                <label for="inputName">Descrição</label>
                                <input type="text" class="form-control" id="inputName">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleFormControlFile1">Imagem de logo</label>
                                <input type="file" class="form-control-file" id="exampleFormControlFile1">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                        <a href="{{route('headers.index')}}" class="btn btn-light border">Cancelar</a>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection

@extends('layouts.app')

@section('title')
    Visualizar Prova
@endsection

@section('content')
    <div class="col-12 mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center mb-3">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Nome da prova
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                    </div>
                </div>

                <div class="col-8">
                    <p><b>Qtd. questões:</b> 10 </p>
                    <p><b>Categoria:</b> Matemática </p>
                    <p><b>Nível:</b> Médio </p>

                    <div class="mt-2">
                        <button type="button" class="btn btn-secondary btn-icon-split p-2">
                            Baixar prova
                        </button>
                        <button type="button" class="btn btn-secondary btn-icon-split p-2">
                            Baixar gabarito
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection

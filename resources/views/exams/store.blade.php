@extends('layouts.app')

@section('title')
    Visualização da prova
@endsection

@section('style')

@endsection

@section('content')

    <div class="col-12 mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row mb-3">
                    <button type="button" onclick="downloadProva()" class="btn btn-primary btn-icon-split p-2 ml-2">
                        <i class="fas fa-file-download mr-2 pt-1"></i> Baixar prova
                    </button>
                    <button type="button" class="btn btn-primary btn-icon-split p-2 ml-2">
                        <i class="fas fa-eye mr-2 pt-1"></i> Visualizar gabarito
                    </button>
                </div>
                <div class="row mb-3" >
                    <div class="card w-100 border border-secondary h-100 py-2">
                        <div class="card-body" id="visualizacaoProva">
                            <div class="testHeader">
                                <img src="{{asset('img/logocaraguasecretaria.png')}}"
                                class="d-inline"
                                width="300px">
                                <h3 class="d-inline">CEI/EMEI Prof° Aparecida Maria Pires de Meneses</h3>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
{{-- node_modules\html2pdf.js\dist\html2pdf.bundle.js --}}
@section('js')
    <script src="{{asset('plugins/html2pdf/html2pdf.bundle.min.js')}}"></script>
    <script>
        function downloadProva(){
            var element = document.getElementById('visualizacaoProva');
            html2pdf(element);
        }
    </script>
@endsection

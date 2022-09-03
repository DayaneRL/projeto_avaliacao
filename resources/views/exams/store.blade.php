@extends('layouts.app')

@section('title')
    Visualização da prova
@endsection

@section('style')
    <style>
        #visualizacaoProva{
            width: 800px;
        }
    </style>

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
                <div class="row mb-3 d-flex justify-content-center" >
                    <div class="card border border-secondary h-100 py-2">
                        <div class="card-body text-dark" id="visualizacaoProva">
                            <div class="testHeader">
                                <img src="{{asset('img/logocaraguasecretaria.png')}}"
                                class="d-inline"
                                width="300px">
                                <h5 class="d-inline">CEI/EMEI Prof° Aparecida Maria Pires de Meneses</h5>
                            </div>
                            {{-- quebra de opções --}}
                            <div class="headerInfo d-flex justify-content-center ">
                                <h3>{{$formData['name']}}</h3>
                            </div>
                            <h5 class="m-0">Professor {{Auth::user()->name}}</h5>
                            <h5 class="m-0 ">Caraguatatuba, 25 de maio de 2022</h5>

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
            var opt = {
                filename: "{{$formData['name']}}",
                html2canvas: {
                    dpi: 192,
                    scale:4,
                    letterRendering: true,
                    useCORS: true
                },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().from(element).set(opt).save();
        }
    </script>
@endsection

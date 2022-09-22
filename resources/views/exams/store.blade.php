@extends('layouts.app')

@section('title')
    Visualização da prova
@endsection

@section('style')
    <style>
        #pdfViewer{
            width: 800px;
            /* reseting css */
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
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
                        <div class="card-body text-dark" id="pdfViewer">

                            {{-- include exam --}}
                            @include('exams.pdf.test');

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
{{-- node_modules\html2pdf.js\dist\html2pdf.bundle.js --}}
@section('js')
    <script>
        function downloadProva(){
            // call the downloadExam function on the ExamController
        }
    </script>
@endsection

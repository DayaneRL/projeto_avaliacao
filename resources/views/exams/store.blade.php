@extends('layouts.app')

@section('title')
    Visualização da prova
@endsection

@section('style')
    <style>
        #pdfViewer{
            width: 800px;
            /* reseting css */
            padding: 20px 40px;
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
                    <button type="button" onclick="saveTest()" id="btnSave" class="btn btn-success btn-icon-split p-2 ml-auto">
                        <i class="fas fa-save mr-2 pt-1"></i> Salvar prova
                    </button>
                    <button type="button" id="btnTest" class="btn btn-primary btn-icon-split p-2 ml-2" disabled>
                        <i class="fas fa-eye mr-2 pt-1" ></i> Visualizar prova
                    </button>
                    <button type="button" id="btnAnswers" class="btn btn-primary btn-icon-split p-2 ml-2" >
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

@section('js')
    <script>

        let btnTest = document.getElementById('btnTest');
        let btnAnswers = document.getElementById('btnAnswers');
        let btnSave = document.getElementById('btnSave');
        let visualizingTest=true;
        let testSaved=false;

        let testId=-1;

        btnTest.addEventListener("click", btnTestClick);
        btnAnswers.addEventListener("click", btnAnswersClick);
        // btnAnswers.addEventListener("click", saveTest);

        function btnTestClick(){
            if(visualizingTest){
                downloadTest();
                return;
            }else{
                if(testSaved){
                    btnTest.innerHTML='<i class="fas fa-file-download mr-2 pt-1"></i> Baixar prova';
                }
            }
            // bring the view of the test again

            if(!testSaved){
                btnTest.disabled=true;
            }
            btnAnswers.disabled=false;

            btnAnswers.innerHTML='<i class="fas fa-eye mr-2 pt-1"></i> Visualizar gabarito';
            visualizingTest=true;

        }

        function btnAnswersClick(){

            if(visualizingTest){
                btnAnswers.disabled=true;

                if(testSaved){
                    btnAnswers.innerHTML='<i class="fas fa-file-download mr-2 pt-1"></i> Baixar gabarito';
                    btnTest.innerHTML='<i class="fas fa-eye mr-2 pt-1"></i> Visualizar prova';
                    btnAnswers.disabled=false;
                }

                btnTest.disabled=false;
                visualizingTest=false;
                // bring the view of the answers
                return;
            }
            // download the answers PDF
            downloadAnswers();
        }

        function saveTest(){
            testSaved=true;
            btnSave.innerHTML='<i class="fas fa-save mr-2 pt-1"></i>Prova salva';
            if(visualizingTest){
                btnTest.disabled=false;
                btnTest.innerHTML='<i class="fas fa-file-download mr-2 pt-1"></i> Baixar prova';
            }else{
                btnAnswers.disabled=false;
                btnAnswers.innerHTML='<i class="fas fa-file-download mr-2 pt-1"></i> Baixar gabarito';
            }
            //function to save the test
            $.ajax({
                url: "save_exam",
                type: 'POST',
                data:
                    {
                        _token: "{{ csrf_token() }}",
                        name: "{{$request->name}}",
                        number_of_questions: "{{$request->number_of_questions}}",
                        date: "{{$request->date}}",
                        questions: "{{json_encode($questions_ids)}}"
                    },
                success: function(response){
                    // handle this success and error
                    console.log(response);
                },
                error: function(response){
                    console.log(response);
                }
            });
        }

        function downloadTest(){
            $.ajax({
                url: "download_exam",
                type: 'POST',
                data: { _token: "{{ csrf_token() }}", name: "{{$request->name}}", },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response){
                    var blob = new Blob([response]);
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "{{$request->name . '.pdf'}}";
                    link.click();
                },
                error: function(blob){
                    console.log(blob);
                }
            });
        }

        function downloadAnswers(){
            $.ajax({
                url: "download_answers",
                type: 'POST',
                data: { _token: "{{ csrf_token() }}", name: "{{$request->name}}", },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response){
                    var blob = new Blob([response]);
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "{{'Gabarito da '.$request->name . '.pdf'}}";
                    link.click();
                },
                error: function(blob){
                    console.log(blob);
                }
            });
        }
        function loadTest(){

        }
        function loadAnswers(){

        }
    </script>
@endsection

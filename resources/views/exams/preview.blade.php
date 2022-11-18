@extends('layouts.app')

@section('title')
    Visualização da prova
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/trumbowyg.min.css') }}">
    <style>
        #pdfViewer {
            width: 800px;
            /* reseting css */
            padding: 20px 40px;
            border: 0;
            font-size: 100%;
            font: inherit;
        }
    </style>
@endsection

@section('content')
    <div class="col-12 mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row mb-3">
                    <button type="button" onclick="saveTest()" id="btnSave"
                        class="btn btn-success btn-icon-split p-2 ml-auto">
                        <i class="fas fa-save mr-2 pt-1"></i> Salvar prova
                    </button>
                    <button type="button" id="btnTest" class="btn btn-primary btn-icon-split p-2 ml-2" disabled>
                        <i class="fas fa-eye mr-2 pt-1"></i> Visualizar prova
                    </button>
                    <button type="button" id="btnAnswers" class="btn btn-primary btn-icon-split p-2 ml-2">
                        <i class="fas fa-eye mr-2 pt-1"></i> Visualizar gabarito
                    </button>
                </div>
                <div class="row mb-3 d-flex justify-content-center">
                    <div class="card border border-secondary h-100 py-2">
                        <div class="card-body text-dark" id="pdfViewer">

                            {{-- include exam --}}
                            @include('exams.pdf.preview.exam')

                        </div>

                    </div>
                </div>
            </div>

            <input type="hidden" value="{{ json_encode($exam['tags']) }}" id="tags">
            <input type="hidden" value="{{ json_encode($exam_attributes) }}" id="exam_attributes">
            <input type="hidden" value="{{ json_encode($questions_ids) }}" id="questions_ids">

        </div>
    </div>
@endsection

@section('js')
    <script>
        let btnTest = document.getElementById('btnTest');
        let btnAnswers = document.getElementById('btnAnswers');
        let btnSave = document.getElementById('btnSave');
        let visualizingTest = true;
        let testSaved = false;
        let initialQuestionText = [];

        let qtdQuestions = {{ $exam['number_of_questions'] }};

        let initialAlternativeText = new Array(qtdQuestions);
        for (i = 0; i < qtdQuestions; i++) {
            initialAlternativeText[i] = new Array(4);
            // for (j = 0; j < 4; j++) {
            //     a[i][j] = '[' + i + ',' + j + ']';
            // }
        }


        // console.log(population);
        let testId = -1;

        btnTest.addEventListener("click", btnTestClick);
        btnAnswers.addEventListener("click", btnAnswersClick);

        function btnTestClick() {
            if (visualizingTest) {
                downloadTest();
                return;
            } else {
                loadTest();
                if (testSaved) {
                    btnTest.innerHTML = '<i class="fas fa-file-download mr-2 pt-1"></i> Baixar prova';
                }
            }
            // bring the view of the test again

            if (!testSaved) {
                btnTest.disabled = true;
            }
            btnAnswers.disabled = false;

            btnAnswers.innerHTML = '<i class="fas fa-eye mr-2 pt-1"></i> Visualizar gabarito';
            visualizingTest = true;

        }

        function btnAnswersClick() {

            if (visualizingTest) {
                btnAnswers.disabled = true;
                loadAnswers();

                if (testSaved) {
                    btnAnswers.innerHTML = '<i class="fas fa-file-download mr-2 pt-1"></i> Baixar gabarito';
                    btnTest.innerHTML = '<i class="fas fa-eye mr-2 pt-1"></i> Visualizar prova';
                    btnAnswers.disabled = false;
                }

                btnTest.disabled = false;
                visualizingTest = false;
                // bring the view of the answers
                return;
            }
            // download the answers PDF
            downloadAnswers();
        }

        function saveTest() {
            testSaved = true;
            btnSave.innerHTML = '<i class="fas fa-save mr-2 pt-1"></i>Salvando...';
            btnSave.disabled = true;
            if (visualizingTest) {
                btnTest.disabled = false;
                btnTest.innerHTML = '<i class="fas fa-file-download mr-2 pt-1"></i> Baixar prova';
            } else {
                btnAnswers.disabled = false;
                btnAnswers.innerHTML = '<i class="fas fa-file-download mr-2 pt-1"></i> Baixar gabarito';
            }

            //function to save the test
            $.ajax({
                url: window.location.origin + '/exams',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    exam: {
                        title: "{{ $exam['title'] }}",
                        number_of_questions: "{{ $exam['number_of_questions'] }}",
                        category_id: "{{ $exam['category_id'] }}",
                        tags: JSON.parse(document.getElementById('tags').value),
                        exam_attributes: JSON.parse(document.getElementById('exam_attributes').value),
                        date: "{{ $exam['date'] }}",
                        questions: JSON.parse(document.getElementById('questions_ids').value)
                    }
                },
                success: function(response) {
                    if (response) {
                        btnSave.innerHTML = '<i class="fas fa-save mr-2 pt-1"></i>Prova salva';
                        btnSave.disabled = true;
                    } else {
                        // avisar o usuario que houve um erro
                        btnSave.innerHTML = '<i class="fas fa-save mr-2 pt-1"></i>Salvar prova';
                        btnSave.disabled = false;
                    }
                },
                error: function(response) {
                    // avisar o usuario que houve um erro
                    btnSave.innerHTML = '<i class="fas fa-save mr-2 pt-1"></i>Salvar prova';
                    btnSave.disabled = false;
                }
            });
        }

        function downloadTest() {
            $.ajax({
                url: "download_exam",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    title: "{{ $exam['title'] }}",
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    var blob = new Blob([response]);
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "{{ $exam['title'] . '.pdf' }}";
                    link.click();
                },
                error: function(blob) {
                    console.log(blob);
                }
            });
        }

        function downloadAnswers() {
            $.ajax({
                url: "download_answers",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    title: "{{ $exam['title'] }}",
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    var blob = new Blob([response]);
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = "{{ 'Gabarito da ' . $exam['title'] . '.pdf' }}";
                    link.click();
                },
                error: function(blob) {
                    console.log(blob);
                }
            });
        }

        function loadTest() {
            btnTest.innerHTML = '<i class="fas fa-file-download mr-2 pt-1"></i> Carregando...';
            btnTest.disabled = true;
            $.ajax({
                url: "load_test",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    title: "{{ $exam['title'] }}",
                },
                success: function(response) {
                    if (response['success']) {
                        document.getElementById('pdfViewer').innerHTML = response['html'];
                        btnTest.innerHTML = '<i class="fas fa-file-download mr-2 pt-1"></i> Baixar prova';
                    }
                },
                error: function(response) {
                    console.log('loadTest error');
                }
            });

        }

        function loadAnswers() {
            btnAnswers.innerHTML = '<i class="fas fa-file-download mr-2 pt-1"></i> Carregando...';
            $.ajax({
                url: "load_answers",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    title: "{{ $exam['title'] }}",
                },
                success: function(response) {
                    if (response['success']) {
                        document.getElementById('pdfViewer').innerHTML = response['html'];
                        btnAnswers.innerHTML = '<i class="fas fa-file-download mr-2 pt-1"></i> Baixar gabarito';
                    }
                },
                error: function(blob) {
                    console.log('loadanswer error')
                }
            });

        }

        function editQuestion(question) {
            initialQuestionText[question] = $('#question' + question + 'Text').text();

            //salva o texto das alternativas, remove os elementos li e cria elementos input.

            // erro por aqui? vê o tamanho de initialAlternativeText. No momento tô trazendo todas questões
            // do banco ignorando a variavel de quantidade de questões. vai dar erro ao mudar a questão 5
            //se você só criou duas questões na view anterior

            saveAlternatives(question);
            let correctAlternative = getCorrectAlternative(question);

            console.log(correctAlternative);

            $('#alternativesOfQuestion' + question).empty();

            appendInput(question);

            markCorrectAlternative(correctAlternative);

            createTrumbowyg(question);

            $('#button' + question).prop("disabled", true);
            $('#button' + question + 'Save').removeClass("d-none").addClass("d-inline");
            $('#button' + question + 'Cancel').removeClass("d-none").addClass("d-inline");
        }

        function saveQuestion(question) {
            console.log('chamou o save pra questao' + question);
            $('#button' + question).prop("disabled", false);
            $('#question' + question + 'Text').trumbowyg('destroy');
            $('#button' + question + 'Save').removeClass("d-inline").addClass("d-none");
            $('#button' + question + 'Cancel').removeClass("d-inline").addClass("d-none");

            let questionText = $('#question' + question + 'Text').text();


            saveEditedAlternatives(question);
            $('#alternativesOfQuestion' + question).empty();
            appendList(question);

        }

        function getCorrectAlternative(question) {
            let varToReturn = false;
            $('#alternativesOfQuestion' + question).children('li').each(function() {
                console.log(this);
                if (this.value === 1) {
                    // retornando só o "2b"
                    // magia, o console log vai e o return não
                    varToReturn =  this.id.slice(-2);
                    console.log(varToReturn);
                }
            });
            return varToReturn;
        }

        function markCorrectAlternative(correctAlternative) {
            // tem o alternativeS e o alternative. programador burro. "depois eu mudo isso"
            console.log(correctAlternative);
            $('#alternativeOfQuestion'+correctAlternative).addClass('bg-success');
        }

        function cancelEdit(question) {
            console.log('chamou o cancelEdit pra questao' + question);

            $('#button' + question).prop("disabled", false);
            $('#question' + question + 'Text').trumbowyg('destroy');
            $('#button' + question + 'Save').removeClass("d-inline").addClass("d-none");
            $('#button' + question + 'Cancel').removeClass("d-inline").addClass("d-none");

            $('#question' + question + 'Text').text(initialQuestionText[question]);

            correctAlternative = getCorrectAlternativeFromInput(question);
            console.log(correctAlternative);
            $('#alternativesOfQuestion' + question).empty();

            appendList(question, correctAlternative);


        }

        function getCorrectAlternativeFromInput(question){
            if($('#alternativeOfQuestion'+question+'a').hasClass('bg-success')){
                return question+'a';
            }
            if($('#alternativeOfQuestion'+question+'b').hasClass('bg-success')){
                return question+'b';
            }
            if($('#alternativeOfQuestion'+question+'c').hasClass('bg-success')){
                return question+'c';
            }
            if($('#alternativeOfQuestion'+question+'d').hasClass('bg-success')){
                return question+'d';
            }
        }

        function appendList(question, correctAlternative) {
            $('#alternativesOfQuestion' + question).append("<li class='answers' id='alternative" + question +
                "a'> <span class='alternative' >A)</span><span id='alternative" + question + "aText'>" +
                initialAlternativeText[question - 1][0] + "</span> </li> ");
            $('#alternativesOfQuestion' + question).append("<li class='answers' id='alternative" + question +
                "b'> <span class='alternative' >B)</span><span id='alternative" + question + "bText'>" +
                initialAlternativeText[question - 1][1] + "</span> </li> ");
            $('#alternativesOfQuestion' + question).append("<li class='answers' id='alternative" + question +
                "c'> <span class='alternative' >C)</span><span id='alternative" + question + "cText'>" +
                initialAlternativeText[question - 1][2] + "</span> </li> ");
            $('#alternativesOfQuestion' + question).append("<li class='answers' id='alternative" + question +
                "d'> <span class='alternative' >D)</span><span id='alternative" + question + "dText'>" +
                initialAlternativeText[question - 1][3] + "</span> </li> ");
            $('#alternative'+ correctAlternative).attr("value",1);
        }

        function appendInput(question) {
            $('#alternativesOfQuestion' + question).append(
                '<div class="input-group my-1"><div class="input-group-prepend"><span class="input-group-text" id="alternativeOfQuestion' +question + 'a' + '">A</span></div><input type="text" id="inputOfQuestion' +
                question + 'a' + '" value="' + initialAlternativeText[question - 1][0] + '" class="form-control"></div>'
            );
            $('#alternativesOfQuestion' + question).append(
                '<div class="input-group my-1"><div class="input-group-prepend"><span class="input-group-text"  id="alternativeOfQuestion' +question + 'b' + '">B</span></div><input type="text" id="inputOfQuestion' +
                question + 'b' + '" value="' + initialAlternativeText[question - 1][1] + '" class="form-control"></div>'
            );
            $('#alternativesOfQuestion' + question).append(
                '<div class="input-group my-1"><div class="input-group-prepend"><span class="input-group-text"  id="alternativeOfQuestion' +question + 'c' + '">C</span></div><input type="text" id="inputOfQuestion' +
                question + 'c' + '" value="' + initialAlternativeText[question - 1][2] + '" class="form-control"></div>'
            );
            $('#alternativesOfQuestion' + question).append(
                '<div class="input-group my-1"><div class="input-group-prepend"><span class="input-group-text"  id="alternativeOfQuestion' +question + 'd' + '">D</span></div><input type="text" id="inputOfQuestion' +
                question + 'd' + '" value="' + initialAlternativeText[question - 1][3] + '" class="form-control"></div>'
            );
        }

        function createTrumbowyg(question) {
            $('#question' + question + 'Text').trumbowyg({
                btns: [
                    ['strong', 'em', ]
                ],
                autogrow: true,
                removeformatPasted: true,
            });

            addMaxLength(question, 5000);
        }

        function addMaxLength(question, max) {
            $('#question' + question + 'Text').trumbowyg().on('tbwchange keydown keyup', function() {
                let txt = $(this).trumbowyg('html');
                //remove tags & special chars -> get "real" text length:
                txt = txt.replace(/(<([^>]+)>)/ig, ""); // remove tags (< >, </ >)
                txt = txt.replace(/&[^;]+;/g, " "); // remove special chars (%n;)

                if (txt.length > max) {
                    // make an alert
                    $('#button' + question + 'Save').prop("disabled", true);
                } else {
                    $('#button' + question + 'Save').prop("disabled", false);
                }
            });
        }

        function saveAlternatives(question) {
            initialAlternativeText[question - 1][0] = $('#alternative' + question + 'aText').text();
            initialAlternativeText[question - 1][1] = $('#alternative' + question + 'bText').text();
            initialAlternativeText[question - 1][2] = $('#alternative' + question + 'cText').text();
            initialAlternativeText[question - 1][3] = $('#alternative' + question + 'dText').text();
        }

        function saveEditedAlternatives(question) {
            console.log('atualizou');
            console.log(question);
            console.log($('#inputOfQuestion' + question + 'a').val());
            initialAlternativeText[question - 1][0] = $('#inputOfQuestion' + question + 'a').val();
            initialAlternativeText[question - 1][1] = $('#inputOfQuestion' + question + 'b').val();
            initialAlternativeText[question - 1][2] = $('#inputOfQuestion' + question + 'c').val();
            initialAlternativeText[question - 1][3] = $('#inputOfQuestion' + question + 'd').val();

            console.log(initialAlternativeText);
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/trumbowyg.min.js"
        integrity="sha512-mBsoM2hTemSjQ1ETLDLBYvw6WP9QV8giiD33UeL2Fzk/baq/AibWjI75B36emDB6Td6AAHlysP4S/XbMdN+kSA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

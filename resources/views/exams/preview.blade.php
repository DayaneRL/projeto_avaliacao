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
            @if (isset($exam['tags']))
                <input type="hidden" value="{{ json_encode($exam['tags']) }}" id="tags">
            @else
                <input type="hidden" value="[]" id="tags">
            @endif

            <input type="hidden" value="{{ json_encode($exam_attributes) }}" id="exam_attributes">
            <input type="hidden" value="{{ json_encode($private_questions) }}" id="private_questions">
            <input type="hidden" value="{{ json_encode($questions) }}" id="questions">
            <input type="hidden" value="{{ json_encode($questions_ids) }}" id="questions_ids">
            <input type="hidden" id="date" value="{{ $exam['date']; }}">
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
        let testId = 0;
        const MAIN_URL = window.location.origin;

        let months = ['', 'janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro']
        const date = $('#date').val();
        const day = date.split('/')[0];
        const month = months[parseInt(date.split('/')[1])];
        const year = date.split('/')[2];

        updateDate();
        function updateDate(){
            $('#day').text(day);
            $('#month').text(month);
            $('#year').text(year);
        }

        const idHeaderImage = {{$exam['header_id']}};

        updateImage();
        function updateImage(){
            if(idHeaderImage==0){
                $('#headerImage').attr("src",MAIN_URL+ '/img/header/logocaraguasecretaria.jpeg');
            }else{
                $.ajax({
                    url: `/findHeader/${idHeaderImage}`,
                    type: 'GET',
                    success: function (response) {
                        $('#headerImage').attr("src",MAIN_URL+ '/storage/'+response.header.logo);
                        $('#headerSchool').text(response.header.description);
                    },
                    error: function (error) {
                        console.log('error');
                        console.log(error);
                    }
                });
            }
        }


        @if(session()->has('testSaved'))
           testSaved = true;
           testId = {{session('testSaved')}}
        @endif

        if (testSaved) {
            btnTest.innerHTML = '<i class="fas fa-file-download mr-2 pt-1"></i> Baixar prova';
            btnAnswers.innerHTML = '<i class="fas  fa-eye mr-2 pt-1"></i> Visualizar gabarito';
            btnSave.disabled = true;
            btnTest.disabled = false;
        }



        let alternatives = ['a','b','c','d'];

        let questionText = [];
        let editedQuestions = [];

        let qtdQuestions = {{ $exam['number_of_questions'] }};

        // isso aqui tá dando erro, mas tá bem podre o código mesmo.
        let alternativeText = new Array();
        for (i = 0; i < qtdQuestions; i++) {
            alternativeText[i] = new Array(4);
        }
        // let alternativeText = [];

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
                    btnAnswers.innerHTML = '<i class="fas fa-save-download mr-2 pt-1"></i> Baixar gabarito';
                    btnTest.innerHTML = '<i class="fas fa-eye mr-2 pt-1"></i> Visualizar prova';
                    btnAnswers.disabled = false;
                }

                btnTest.disabled = false;
                visualizingTest = false;
                return;
            }
            downloadAnswers();
        }

        function saveTest() {
            let privateQuestionsObject = {
                "private_questions": []
            }
            editedQuestions.forEach(editedQuestion => {
                let answer = getAlternativesAsObject(editedQuestion);
                let private_question = {
                    "description": questionText[editedQuestion],
                    answer
                };
                privateQuestionsObject.private_questions.push(private_question);
            });

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
                        date: "{{ $exam['date'] }}",
                        questions: JSON.parse(document.getElementById('questions_ids').value),
                        editedQuestions,
                        privateQuestionsObject,
                        user_header_id: idHeaderImage
                    },
                    exam_attributes: JSON.parse(document.getElementById('exam_attributes').value),
                    private_questions:  JSON.parse(document.getElementById('private_questions').value),
                },
                success: function(response) {
                    if (response) {
                        btnSave.innerHTML = '<i class="fas fa-save mr-2 pt-1"></i>Prova salva';
                        btnSave.disabled = true;
                        testId =  response;
                    } else {
                        btnSave.innerHTML = '<i class="fas fa-save mr-2 pt-1"></i>Salvar prova';
                        btnSave.disabled = false;
                    }
                },
                error: function(response) {
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
                    id: testId
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
                    id: testId
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
                    questions: JSON.parse(document.getElementById('questions').value)
                },
                success: function(response) {
                    if (response['success']) {
                        document.getElementById('pdfViewer').innerHTML = response['html'];
                        btnTest.innerHTML = '<i class="fas fa-file-download mr-2 pt-1"></i> Baixar prova';
                        updateImage();
                        updateDate();
                    }
                },
                error: function(response) {
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
                    questions: JSON.parse(document.getElementById('questions').value)
                },
                success: function(response) {
                    if (response['success']) {
                        document.getElementById('pdfViewer').innerHTML = response['html'];
                        btnAnswers.innerHTML = '<i class="fas fa-file-download mr-2 pt-1"></i> Baixar gabarito';
                        updateImage();
                        updateDate();
                    }
                },
                error: function(blob) {
                    console.log('loadanswer error')
                }
            });

        }

        function editQuestion(question) {
            questionText[question] = $('#question' + question + 'Text').text().trim();
            saveAlternatives(question);

            let correctAlternative = getCorrectAlternative(question);

            $('#alternativesOfQuestion' + question).empty();

            appendInput(question);

            markCorrectAlternative(correctAlternative);

            createTrumbowyg(question);

            $('#button' + question).prop("disabled", true);
            $('#button' + question + 'Save').removeClass("d-none").addClass("d-inline");
            $('#button' + question + 'Cancel').removeClass("d-none").addClass("d-inline");
        }



        function getCorrectAlternative(question) {
            let varToReturn = false;
            $('#alternativesOfQuestion' + question).children('li').each(function() {
                if (this.value === 1) {
                    varToReturn =  this.id.slice(-2);
                }
            });
            return varToReturn;
        }

        function markCorrectAlternative(correctAlternative) {
            $('#alternativeOfQuestion'+correctAlternative).addClass('bg-success');
            $('#alternativeOfQuestion'+correctAlternative).css('color','#fff');
        }

        function cancelEdit(question) {
            $('#button' + question).prop("disabled", false);
            $('#question' + question + 'Text').trumbowyg('destroy');
            $('#button' + question + 'Save').removeClass("d-inline").addClass("d-none");
            $('#button' + question + 'Cancel').removeClass("d-inline").addClass("d-none");

            $('#question' + question + 'Text').text(questionText[question]);

            correctAlternative = getCorrectAlternativeFromInput(question);

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
            let questionNumber = $('#questionNumberOfQuestion'+ question).text()-1;
            $('#alternativesOfQuestion' + question).append("<li class='answers' id='alternative" + question +
                "a'> <span class='alternative' >A)</span><span id='alternative" + question + "aText'>" +
                alternativeText[questionNumber][0] + "</span> </li> ");
            $('#alternativesOfQuestion' + question).append("<li class='answers' id='alternative" + question +
                "b'> <span class='alternative' >B)</span><span id='alternative" + question + "bText'>" +
                alternativeText[questionNumber][1] + "</span> </li> ");
            $('#alternativesOfQuestion' + question).append("<li class='answers' id='alternative" + question +
                "c'> <span class='alternative' >C)</span><span id='alternative" + question + "cText'>" +
                alternativeText[questionNumber][2] + "</span> </li> ");
            $('#alternativesOfQuestion' + question).append("<li class='answers' id='alternative" + question +
                "d'> <span class='alternative' >D)</span><span id='alternative" + question + "dText'>" +
                alternativeText[questionNumber][3] + "</span> </li> ");
            $('#alternative'+ correctAlternative).attr("value",1);
        }

        function appendInput(question) {
            let questionNumber = $('#questionNumberOfQuestion'+ question).text()-1;
            $('#alternativesOfQuestion' + question).append(
                '<div class="input-group my-1"><div class="input-group-prepend"><span class="input-group-text" id="alternativeOfQuestion' +question + 'a' + '">A</span></div><input type="text" id="inputOfQuestion' +
                question + 'a' + '" value="' + alternativeText[questionNumber][0] + '" class="form-control"></div>'
            );
            $('#alternativesOfQuestion' + question).append(
                '<div class="input-group my-1"><div class="input-group-prepend"><span class="input-group-text"  id="alternativeOfQuestion' +question + 'b' + '">B</span></div><input type="text" id="inputOfQuestion' +
                question + 'b' + '" value="' + alternativeText[questionNumber][1] + '" class="form-control"></div>'
            );
            $('#alternativesOfQuestion' + question).append(
                '<div class="input-group my-1"><div class="input-group-prepend"><span class="input-group-text"  id="alternativeOfQuestion' +question + 'c' + '">C</span></div><input type="text" id="inputOfQuestion' +
                question + 'c' + '" value="' + alternativeText[questionNumber][2] + '" class="form-control"></div>'
            );
            $('#alternativesOfQuestion' + question).append(
                '<div class="input-group my-1"><div class="input-group-prepend"><span class="input-group-text"  id="alternativeOfQuestion' +question + 'd' + '">D</span></div><input type="text" id="inputOfQuestion' +
                question + 'd' + '" value="' + alternativeText[questionNumber][3] + '" class="form-control"></div>'
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

        function saveQuestion(question) {
            // console.log('chamou o save pra questao' + question);
            $('#button' + question).prop("disabled", false);
            $('#question' + question + 'Text').trumbowyg('destroy');
            $('#button' + question + 'Save').removeClass("d-inline").addClass("d-none");
            $('#button' + question + 'Cancel').removeClass("d-inline").addClass("d-none");

            // update the question text
            let thisQuestionText = $('#question' + question + 'Text').text().trim();

            alternativeWasEdited = saveEditedAlternatives(question);

            if((thisQuestionText != questionText[question]) || alternativeWasEdited ){
                editedQuestions[question]=question;
            }

            questionText[question] = thisQuestionText;

            let correctAlternative = getCorrectAlternativeFromInput(question);
            $('#alternativesOfQuestion' + question).empty();
            appendList(question,correctAlternative);

        }

        function saveAlternatives(question) {
            let questionNumber = $('#questionNumberOfQuestion'+ question).text()-1;
            alternativeText[questionNumber][0] = $('#alternative' + question + 'aText').text();
            alternativeText[questionNumber][1] = $('#alternative' + question + 'bText').text();
            alternativeText[questionNumber][2] = $('#alternative' + question + 'cText').text();
            alternativeText[questionNumber][3] = $('#alternative' + question + 'dText').text();
        }

        function saveEditedAlternatives(question) {
            let questionNumber = $('#questionNumberOfQuestion'+ question).text()-1;
            let wasEdited = false;
            for(let i=0; i<4; i++){
                if(alternativeText[questionNumber][i] != $('#inputOfQuestion' + question + alternatives[i]).val()){
                    wasEdited=true;
                }
                alternativeText[questionNumber][i] = $('#inputOfQuestion' + question + alternatives[i]).val()
            }
            return wasEdited;
        }

        function getAlternativesAsObject(question){
            let objectToReturn = [];

            $('#alternativesOfQuestion' + question).children('li').each( function(counter) {
                let valid = 0;
                if (this.value === 1) {
                    valid =  1;
                }
                let answer = {
                    "alternative": alternatives[counter],
                    "description": $('#'+ this.id + "Text").text(),
                    "valid": valid
                }
                objectToReturn.push(answer);
            });
            return(objectToReturn);


        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/trumbowyg.min.js"
        integrity="sha512-mBsoM2hTemSjQ1ETLDLBYvw6WP9QV8giiD33UeL2Fzk/baq/AibWjI75B36emDB6Td6AAHlysP4S/XbMdN+kSA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

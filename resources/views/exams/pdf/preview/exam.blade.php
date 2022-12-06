<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prova</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @font-face {
            font-family: 'Open Sans', sans-serif;
            font-style: normal;
            font-weight: normal;
            src: url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap") format('Open Sans');
        }

        html {
            font-family: 'Open Sans', sans-serif;
        }

        .header {
            text-align: center;
        }

        .headerImg {
            height: 100px;
            width: auto;
            display: block;
            margin: 0 auto 10px auto;
        }

        .questionImg {
            width: 250px;
            display: block;
        }

        .institutionName,
        .titleTest {
            width: 100%;
            font-size: 20px;
            line-height: 30px;
            display: block;
            margin: 0;
        }

        .testInfo {
            margin-bottom: 20px;
        }

        .testInfo p {
            font-size: 12;
            line-height: 20px;
            display: block;
            margin: 0;
        }

        .questionNumber {
            font-weight: bold;
            margin: 30px 0 0 0;
            display: inline;
        }

        .answers {
            list-style: none;
            padding-left: 0;
        }

        .questionText,
        .answers li {
            text-align: justify;
            text-justify: inter-word;
        }

        .alternative {
            text-transform: uppercase;
        }
        .card-body{
            display: flex;
            flex-direction: column;
            position: relative;
        }
        .btnEdit{
            position: absolute;
            top: 30px;
            right: 10px;
        }
        .trumbowyg-box,
        .trumbowyg-editor {
            min-height: 150px;
        }
        .trumbowyg-editor p{
            line-height: 1.3em;
            margin: 0;
        }
        .actionBtn{
            width: fit-content;
            display: in
        }

        .ulAlternatives{
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="" id="headerImage" class="headerImg">

        {{-- var MAIN_URL = window.location.origin; --}}
        {{-- /storage/${response.header.logo} --}}

        <p class="institutionName">
            CEI/EMEI Prof° Aparecida Maria Pires de Meneses
        </p>
        <p class="titleTest">
            {{ $exam['title'] }}
        </p>
    </div>
    <div class="testInfo">
        <p>Professor {{ Auth::user()->name }}</p>
        <p>Caraguatatuba, 25 de maio de 2022</p>
        <p class="studentName">Nome: _____________________________________________________________</p>
    </div>
    @php
        $questionNumber = 1;
    @endphp

    @foreach ($questions as $question)
        <div class="card shadow h-100 my-3 px-2">
            <div class="card-body" id="question{{$question['id']}}">
                <button class="btn btn-warning btnEdit" id="button{{$question['id']}}" onclick="editQuestion({{$question['id']}})">
                    <i class="fas fa-pen mr-2 pt-1"></i>Editar questão
                </button>
                <p class="questionNumber">Questão <span id="questionNumberOfQuestion{{$question['id']}}">{{ $questionNumber++ }} </span></p>

                @if ($question['image'])
                    <img src="{{ $question['image'] }} " class="questionImg">
                @endif

                <p class="questionText" id="question{{$question['id']}}Text">{{ $question['description'] }}</p>
                <ul id="alternativesOfQuestion{{$question['id']}}" class="ulAlternatives">
                @foreach ($question['answers'] as $reply)
                    <li class="answers" id="alternative{{$question['id'].$reply['alternative']}}" value="{{ $reply['valid'] }}">
                        <span class="alternative" >{{ $reply['alternative'] }})</span>
                        <span id="alternative{{$question['id'].$reply['alternative']}}Text">{{ $reply['description'] }}</span>
                    </li>
                @endforeach
                </ul>

                <button class="btn btn-success d-none actionBtn" id="button{{$question['id']}}Save" onclick="saveQuestion({{$question['id']}})">
                    <i class="fas fa-save mr-2 pt-1"></i>Salvar questão
                </button>
                <button class="btn btn-danger d-none actionBtn" id="button{{$question['id']}}Cancel" onclick="cancelEdit({{$question['id']}})">
                    <i class="fas fa-trash mr-2 pt-1"></i>Cancelar
                </button>
            </div>
        </div>
    @endforeach

</body>

</html>

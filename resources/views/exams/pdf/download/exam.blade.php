<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prova</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: 'Open Sans', sans-serif;
            font-style: normal;
            font-weight: normal;
            src: url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap") format('Open Sans');
        }
        html{
            font-family: 'Open Sans', sans-serif;
        }
        .header{
            text-align: center;
        }
        .headerImg{
            height:100px;
            width: auto;
            display: block;
            margin: 0 auto 10px auto;
        }
        .questionImg{
            height:100px;
            display: block;
        }
        .institutionName, .titleTest{
            width: 100%;
            font-size: 20px;
            line-height: 30px;
            display: block;
            margin: 0;
        }
        .testInfo{
            margin-bottom: 20px;
        }
        .testInfo p{
            font-size: 12;
            line-height: 20px;
            display: block;
            margin: 0;
        }
        .questionNumber{
            font-weight: bold;
        }
        .answers{
            list-style: none;
            padding-left: 0;
        }
        .questionText, .answers li{
            text-align: justify;
            text-justify: inter-word;
        }
        .alternative{
            text-transform: uppercase;
        }
        /* .studentName{
            display: block;
            border-bottom: 1px solid #000;
            line-height: 14px;
            margin: 10px 0;
        } */
    </style>
</head>
<body>
    <div class="header">
        <img src="https://www.caraguatatuba.sp.gov.br/assets/logos/brasao_hor.png" class="headerImg">
        {{-- <img src="{{ public_path('img/logocaraguasecretaria.png') }}" class="headerImg"> --}}
        <p class="institutionName">
            CEI/EMEI Prof° Aparecida Maria Pires de Meneses
        </p>
        <p class="titleTest">

            {{$exam['title']}}
        </p>
    </div>
    <div class="testInfo">
        <p>Professor {{Auth::user()->name}}</p>
        <p>Caraguatatuba, 25 de maio de 2022</p>
        <p class="studentName">Nome: _____________________________________________________________</p>
    </div>
        @php
            $questionNumber = 1;

        @endphp

        @foreach ($questions as $question)

            <p class="questionNumber">Questão {{$questionNumber++}}</p>
            @if ($question->image)
                <img src="{{ $question->image}} " class="questionImg">
            @endif
            <p class="questionText">{{$question->description}}</p>
            @foreach ($replys as $reply)
                @if($reply->question_id == $question->id)
                    <li class="answers">
                        <span class="alternative">{{$reply->alternative}})</span>
                        {{$reply->description}}
                    </li>
                @endif

            @endforeach
            {{-- <li class="answers">
                <p>E) <strong>Resposta certa</strong></p>
            </li> --}}
        @endforeach

</body>
</html>

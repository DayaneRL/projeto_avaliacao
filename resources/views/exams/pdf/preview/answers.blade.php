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
            width: 100%;
        }
        body{
            width: 100%;
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
        .testInfo p{
            font-size: 12;
            line-height: 20px;
            display: block;
            margin: 0;
        }

        .answers{
            width: 100%;
            margin-top: 20px;
        }
        table{
            margin: 0 auto;
            border-collapse: collapse;
        }
        table, td, th{
            border: 1px solid black;
            text-align: center;
        }
        td, th{
            padding: 4px;
        }
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
            Gabarito da prova: {{$exam['title']}}
        </p>
    </div>
    <div class="testInfo">
        <p>Professor {{Auth::user()->name}}</p>
        <p>Caraguatatuba, 25 de maio de 2022</p>
    </div>
        @php
            $questionNumber = 1;
        @endphp


    <div class="answers">

            <table>
                <thead>
                    <tr>
                        <th>Questão</th>
                        <th>Gabarito</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $question)
                    <tr>
                        <td>{{ $questionNumber++ }}</td>
                        <td>
                            @foreach ($replys as $reply)
                                @if ($reply->question_id == $question->id)
                                    {{$reply->alternative}}
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

    </div>
        {{-- @foreach ($questions as $question)



        @endforeach --}}


</body>
</html>

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
        <img src="{{base_path().$image }}" class="headerImg">
        <p class="institutionName">
            {{$schoolName}}
        </p>
        <p class="titleTest">
            Gabarito da prova: {{$exam['title']}}
        </p>
    </div>
    <div class="testInfo">
        <p>Professor {{Auth::user()->name}}</p>
        <p>Caraguatatuba, {{$examDate}}</p>
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
                            @foreach ($question['answers'] as $answer)
                                @if ($answer['valid'])
                                    {{$answer['alternative']}}
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

    </div>
</body>
</html>

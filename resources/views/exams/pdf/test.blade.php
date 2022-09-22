<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prova</title>

    <style>
        *{
            margin: 0;
            padding: 0;
        }
        html, body{
            width: 100%;
            font-family: sans-serif;
        }
        .testContainer{
            margin: 30px;
        }
        .header{
            width: 100%;
            margin: 0 auto;
            text-align: center;
            font-size: 18PX;
        }
        .imgHeader{
            height: 100px;
            margin-bottom: 20px;
        }
        .testInfo{
            font-size: 16px;
        }
        .questionNumber{
            font-size: 16px;
            margin: 10px 0;
        }
        .questionImg{
            max-height: 200px;
            max-width: 600px;
        }
    </style>
</head>
<body>
    <div class="testContainer">
        <div class="header">
            <img src="https://www.caraguatatuba.sp.gov.br/assets/logos/brasao_hor.png" class="imgHeader">
            {{-- <img src="{{ public_path().'/img/logocaraguasecretaria.png' }}" class="imgHeader"> --}}
            <p>CEI/EMEI Prof° Aparecida Maria Pires de Meneses</p>
            <p>{{ $request->name }}</p>
        </div>
        <div class="testInfo">
            <p>Professor {{$userRole = auth()->user()->name;}}</p>
            <p>Caraguatatuba, 25 de maio de 2022</p>
        </div>
        @php
            $questionCounter = 1;

        @endphp
        <div class="questions">

            @foreach ($questions as $question)
                <h6 class="questionNumber">Questão {{$questionCounter++}}</h6>

                @if ($question['img'])
                    <img src="{{$question['img']}}" class="questionImg">
                @endif

                <p>{{$question['text']}}</p>

                @foreach ($replys as $answer)
                    @if ($answer['question_id']==$question['id'])
                        <p>{{ $answer['alternative'] . ') ' . $answer['text'] }}</p>
                    @endif
                @endforeach
            @endforeach
        </div>



    </div>



</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prova</title>

    <style>
        .image{
            width: auto;
            height: 100px;
            width: 200px;
            background-image: url( "{{asset('img/logocaraguasecretaria.png')}}" );
            display: block;
        }
        /* .quebraPagina{
            width: 200px;
            height: 200px;
            background-color: red;
            margin: 10px;
        } */
      </style>
</head>
<body>
    <!-- teste 1 -->
    <h1>Path: </h1>
    <h2>Imagem 1:</h2>

    <div class="image"></div>


    <br><br><br>
    <h2>Imagem 2:</h2>
    <!-- teste 2 -->
    {{-- <img src="{{ asset('img/logocaraguasecretaria.png') }}" style="height:100px;">

    <h3>{{'teste'. asset('img/logocaraguasecretaria.png') }}</h3> --}}

    <!-- <div class="quebraPagina"></div>
    <div class="quebraPagina"></div>
    <div class="quebraPagina"></div>
    <div class="quebraPagina"></div> -->
</body>
</html>

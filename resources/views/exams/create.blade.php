@extends('layouts.app')

@section('title')
    Cadastrar Avaliação
@endsection

@section('style')
    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('plugins/trumbowyg/ui/trumbowyg.min.css')}}">
    <link href="{{asset('css/exams/create.css')}}" rel="stylesheet" />
@endsection

@section('content')
    <div class="col-12 mb-4">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="dados-tab" data-toggle="tab" href="#dadosGerais" role="tab" aria-controls="dadosGerais" aria-selected="true">Dados Gerais</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="questoes-tab" data-toggle="tab" href="#Questoes" role="tab" aria-controls="Questoes" aria-selected="false">Questoes</a>
            </li>
        </ul>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="row mb-3">
        @if(isset($exam))
            <form action="{{route('exams.update',$exam->id)}}" method="POST" class="col-12">
        @else
            <form action="{{route('exams.preview')}}" method="POST" class="col-12">
        @endif
                @csrf
                @if(isset($exam))
                    @method('PUT')
                @endif

                <div class="tab-content" id="myTabContent">
                    @include('exams._partials.dados')
                    @include('exams._partials.questoes')
                </div>

            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('plugins/select2/select2.min.js')}} "></script>
    <script src="{{asset('js/jquery.mask.js')}}"></script>
    <script src="{{asset('js/exams/create.js')}}"></script>

    {{-- trumbowyg --}}
    <script src="{{asset('plugins/trumbowyg/trumbowyg.min.js')}}"></script>
    <script>
        $('.editor').trumbowyg({
            btns: [['strong', 'em',]],
            autogrow: true,
            removeformatPasted: true,
        });
    </script>
@endsection

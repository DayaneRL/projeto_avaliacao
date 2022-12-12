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
              <a class="nav-link" id="questoes-tab" role="tab" aria-controls="Questoes" aria-selected="false" onclick="validate()">Questoes</a>
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
            <form action="{{route('exams.update',$exam->id)}}" method="POST" class="col-12" id="formExam">
        @else
            <form action="{{route('exams.preview')}}" method="POST" class="col-12" id="formExam">
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
    <script src="{{asset('plugins/jquery/jquery.validate.min.js')}}"></script>
    <script src="{{asset('plugins/jquery/additional-methods.min.js')}}"></script>

    <script>
        $('.editor').trumbowyg({
            btns: [['strong', 'em',]],
            autogrow: true,
            removeformatPasted: true,
        });
    </script>

    <script>
        $(document).ready(function(){
            $("#formExam").validate({
                errorElement:"span",
                messages:{
                    "exam[title]":{
                        required:"Esse campo é obrigatório",
                    },
                    "exam[date]": {
                        required:"Esse campo é obrigatório",
                    },
                }
            });
            jQuery.extend(jQuery.validator.messages, {
                required: "Esse campo é obrigatório",
            });
        })

        function validate(){
            if($('#inputCategory').val()==""){
                $('#inputCategory').parents('.form-group').find('.obg').remove();
                $('#inputCategory').parents('.form-group').find('.select2').after('<span class="text-danger obg">Esse campo é obrigatório</span>');
            }

            if($("#formExam").valid() && $('#inputCategory').val()!==""){
               $('#questoes-tab').attr('href',"#Questoes");
               $('#questoes-tab').attr('data-toggle',"tab");
            }
        }

        function validateQuestions(e){
            if($("#formExam").valid()){
                $("#formExam").submit();
            }
        }

        $(document).on('change', '#inputCategory', function(){
            $('#inputCategory').parents('.form-group').find('.obg').remove();
        })
    </script>

@endsection

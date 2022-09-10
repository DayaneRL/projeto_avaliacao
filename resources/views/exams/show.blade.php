@extends('layouts.app')

@section('title')
    Visualizar Prova
@endsection

@section('content')
    <div class="col-12 mb-4">
        <div class="card  border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center mb-3">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            PROVA - {{$exam->title}}
                        </div>
                    </div>
                    <div class="col-auto">
                        <a href="{{route('exams.index')}}" class="btn btn-light border btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-left"></i>
                            </span>
                            <span class="text">Voltar</span>
                        </a>
                    </div>
                </div>

                <div class="col-12 text-center">
                    <h3>{{$exam->title}}</h3>

                    <p><b>Tags:</b> {{$exam->tags}} </p>
                    <p><b>Total de questões:</b> {{$exam->number_of_questions}} </p>
                    <p><b>Categoria:</b> {{$exam->Category->name}} </p>
                    <p><b>Data da prova:</b> {{$exam->exam_date}} </p>

                    <hr/>
                    @foreach ($exam->Attributes as $attribute)
                        <p><b>Qtd. de questões:</b> {{$attribute->number_of_questions}},
                           <b>Nível:</b> {{$attribute->level_name}} </p>
                    @endforeach
                    <hr/>

                    <div class="mt-2">
                        <button type="button" class="btn btn-info btn-icon-split p-2">
                            Baixar prova
                        </button>
                        <button type="button" class="btn btn-warning btn-icon-split p-2">
                            Baixar gabarito
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection

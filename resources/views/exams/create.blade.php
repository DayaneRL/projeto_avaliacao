@extends('layouts.app')

@section('title')
    Cadastrar Prova
@endsection

@section('style')
    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet" />
    <style>
        .select2-selection{
            border: 1px solid #d1d3e2 !important;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple{
            color:#6e707e;
            background-color:#fff;
            border-color:#bac8f3;
            outline:0;
            box-shadow:0 0 0 .2rem rgba(78,115,223,.25)
        }
    </style>
@endsection

@section('content')
    <div class="col-12 mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row mb-3">
                    <form action="{{route('exams.store')}}" method="POST" class="col-12">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputName">Título da avaliação</label>
                                <input type="text" class="form-control" id="inputName"
                                placeholder="Avaliação História segundo bimestre">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputName">Tags</label>
                                <select class="js-example-basic-multiple form-control" name="states[]" multiple="multiple">
                                    <option value="AL">Alabama</option>
                                    <option value="NY">Nova York</option>
                                    <option value="WY">Wyoming</option>
                                  </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputQuant">Quantidade de questões</label>
                                <input type="text" class="form-control" id="inputQuant" placeholder="10">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputState">Categoria</label>
                                <select id="inputState" class="form-control">
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputState">Nível</label>
                                <select id="inputState" class="form-control">
                                   @foreach ($levels as $level)
                                        <option value="{{$level->id}}">{{$level->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck">
                                <label class="form-check-label" for="gridCheck">
                                Baixar prova e gabarito
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Gerar Pova</button>
                        <a href="{{route('exams.index')}}" class="btn btn-light border">Cancelar</a>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('plugins/select2/select2.min.js')}} "></script>
    <script src="{{asset('js/exams/create.js')}}"></script>
@endsection

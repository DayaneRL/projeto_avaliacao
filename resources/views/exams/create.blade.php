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
                    <form action="{{route('exams.store')}}" method="POST" class="col-12">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputName">Título da avaliação<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="inputName" name="exam[title]"
                                placeholder="Avaliação História segundo bimestre" value="{{old('exam.title')}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputName">Tags<span class="text-danger">*</span></label>
                                <select class="js-example-basic-multiple form-control" name="exam[tags][]" multiple="multiple">
                                    {{-- trazer do banco dinamico --}}
                                    <option value="primeira_guerra">Primeira Guerra</option>
                                    <option value="guerra_fria">Guerra Fria</option>
                                    <option value="baskara">Baskara</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputTotQuant">Total de questões<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="inputTotQuant" name="exam[number_of_questions]" placeholder="10"
                                value="{{old('exam.number_of_questions')}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputCategory">Categoria<span class="text-danger">*</span></label>
                                <select id="inputCategory" class="form-control" name="exam[category_id]">
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}"
                                            @if(old('exam.category_id')==$category->id) selected @endif>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputData">Data da prova<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="inputData" name="exam[date]" placeholder="xx/xx/xxxx"
                                value="{{old('exam.date')}}">
                            </div>
                        </div>

                        <div class="exam-attributes">
                            <div class="form-row attribute">
                                <div class="form-group col-md-3">
                                    <label for="inputQuant">Qtd. de questões <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control input-quant" id="inputQuant" name="exam_attributes[0][number_of_questions]"
                                    value="{{old('exam_attributes.0.number_of_questions')}}">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputState_0">Nível <span class="text-danger">*</span></label>
                                    <select id="inputState_0" class="form-control" name="exam_attributes[0][level_id]">
                                        @foreach ($levels as $level)
                                        <option value="{{$level->id}}"
                                            @if(old('exam_attributes.0.level_id')==$level->id) selected @endif>{{$level->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3 pt-3">
                                    <button type="button" class="btn btn-primary mt-3 btn-icon-split p-2 pr-3 pl-3 add-row-exam">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger mt-3 btn-icon-split p-2 pr-3 pl-3 rm-row-exam disabled" disabled="true">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck">
                                <label class="form-check-label" for="gridCheck">
                                Baixar prova e gabarito
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submit-exam">Gerar Pova</button>
                        <a href="{{route('exams.index')}}" class="btn btn-light border">Cancelar</a>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('plugins/select2/select2.min.js')}} "></script>
    <script src="{{asset('js/jquery.mask.js')}}"></script>
    <script src="{{asset('js/exams/create.js')}}"></script>
@endsection

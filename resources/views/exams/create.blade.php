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
                    <form action="{{isset($exam)?route('exams.update',$exam->id):route('exams.store')}}" method="POST" class="col-12">
                        @csrf
                        @if(isset($exam))
                            @method('PUT')
                        @endif
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputName">Título da avaliação<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="inputName" name="exam[title]"
                                    required value="{{$exam->title??old('exam.title')}}">
                                <small class="text-secondary">Exemplo: Avaliação História segundo bimestre</small>
                            </div>

                            <div class="form-group col-md-5">
                                <label for="inputCategory">Categoria<span class="text-danger">*</span></label>
                                <select class="form-control js-select2" id="inputCategory" name="exam[category_id]"  required>
                                    <option>Selecione...</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}"
                                            @if(old('exam.category_id')==$category->id||
                                                (isset($exam)&&$exam->category_id==$category->id) )
                                                selected
                                            @endif
                                        >{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="inputName">Tags</label>
                                <select class="js-select2 form-control" id="tags" name="exam[tags][]" multiple="multiple" required>
                                    @foreach ($tags as $key => $tag)
                                        <option value="{{$tag->id}}-{{$tag->category_id}}"
                                            @if(isset($exam)&&in_array($tag->description, $exam->tags_list))
                                                selected
                                            @endif
                                        >{{$tag->description}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputTotQuant">Total de questões<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="inputTotQuant" name="exam[number_of_questions]"
                                value="{{$exam->number_of_questions??old('exam.number_of_questions')}}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputData">Data da prova<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="inputData" name="exam[date]"
                                value="{{isset($exam->date)?$exam->exam_date:old('exam.date')}}" required>
                            </div>
                        </div>

                        <div class="exam-attributes">
                            @if(isset($exam->Attributes))
                                @foreach ($exam->Attributes as $key => $attribute)
                                    <div class="form-row attribute">
                                        <input type="hidden" name="exam_attributes[{{$key}}][id]" value="{{$attribute->id}}">
                                        <div class="form-group col-md-4">
                                            <label for="inputQuant">Qtd. de questões <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control input-quant" id="inputQuant" name="exam_attributes[{{$key}}][number_of_questions]"
                                            value="{{ $attribute->number_of_questions}}" required>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="inputState_0">Nível <span class="text-danger">*</span></label>
                                            <select id="inputState_0" class="form-control" name="exam_attributes[{{$key}}][level_id]" required>
                                                @foreach ($levels as $level)
                                                <option value="{{$level->id}}"
                                                    @if(old('exam_attributes.0.level_id')==$level->id || $attribute->level_id==$level->id) selected @endif
                                                >{{$level->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4 pt-3">
                                            <button type="button" class="btn btn-primary mt-3 btn-icon-split p-2 pr-3 pl-3 add-row-exam">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger mt-3 btn-icon-split p-2 pr-3 pl-3 rm-row-exam {{$key==0?'disabled':''}}" {{$key==0?'disabled':''}}>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>

                                @endforeach
                            @else
                                <div class="form-row attribute">
                                    <div class="form-group col-md-4">
                                        <label for="inputQuant">Qtd. de questões <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control input-quant" id="inputQuant" name="exam_attributes[0][number_of_questions]"
                                        value="{{old('exam_attributes.0.number_of_questions')}}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="inputState_0">Nível <span class="text-danger">*</span></label>
                                        <select id="inputState_0" class="form-control" name="exam_attributes[0][level_id]">
                                            @foreach ($levels as $level)
                                            <option value="{{$level->id}}"
                                                @if(old('exam_attributes.0.level_id')==$level->id) selected @endif>{{$level->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 pt-3">
                                        <button type="button" class="btn btn-primary mt-3 btn-icon-split p-2 pr-3 pl-3 add-row-exam">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger mt-3 btn-icon-split p-2 pr-3 pl-3 rm-row-exam disabled" disabled="true">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="form-group mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck">
                                <label class="form-check-label" for="gridCheck">
                                Baixar prova e gabarito
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submit-exam">{{isset($exam)?'Salvar':'Gerar'}} Pova</button>
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

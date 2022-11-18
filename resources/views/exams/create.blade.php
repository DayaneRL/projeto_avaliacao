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
                        <form action="{{route('exams.preview')}}" method="POST" class="col-12">
                        @csrf
                        @if(isset($exam))
                            @method('PUT')
                        @endif

                        <div class="card border-left-primary py-2 mb-4">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center mb-3">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Dados Gerais
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-9">
                                        <label for="inputName">Título<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="inputName" name="exam[title]"
                                            required value="{{$exam->title??old('exam.title')}}">
                                        {{-- <small class="text-secondary">Exemplo: Avaliação História segundo bimestre</small> --}}
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputData">Data da avaliação<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="inputData" name="exam[date]"
                                        value="{{isset($exam->date)?$exam->exam_date:old('exam.date')}}" required>
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
                                </div>

                            </div>
                        </div>

                        <div class="card border-left-primary py-2 mb-4">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center mb-3">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            questões
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="inputTotQuant">Total de questões<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="inputTotQuant" name="exam[number_of_questions]"
                                        value="{{$exam->number_of_questions??old('exam.number_of_questions')}}" required>
                                    </div>
                                </div>

                                    <div class="exam-attributes mb-4">
                                        @if(isset($exam->Attributes))
                                            @foreach ($exam->Attributes as $key => $attribute)
                                                <div class="form-row attribute">
                                                    <input type="hidden" name="exam_attributes[{{$key}}][id]" value="{{$attribute->id}}">
                                                    <div class="form-group col-md-3">
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
                                                    <div class="form-group col-md-5 pt-3">
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

                                            {{-- <div class="form-row border-left-info rounded attribute">
                                                <div class="form-group col-md-3">
                                                    <label for="inputQuant">Qtd. de questões <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control input-quant" id="inputQuant" name="exam_attributes[0][number_of_questions]"
                                                    value="{{old('exam_attributes.0.number_of_questions')}}">
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="inputState_0">Nível <span class="text-danger">*</span></label>
                                                    <select id="inputState_0" class="form-control" name="exam_attributes[0][level_id]">
                                                        @foreach ($levels as $level)
                                                            <option value="{{$level->id}}"
                                                                @if(old('exam_attributes.0.level_id')==$level->id) selected @endif
                                                            >{{$level->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-5 pt-3">
                                                    <button type="button" class="btn btn-info mt-3 btn-icon-split py-2 px-3 add-row-exam">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-info mt-3 btn-icon-split py-2 px-3 rm-row-exam disabled" disabled="true">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>

                                            </div> --}}
                                        @endif
                                    </div>
                                    <div class="row mb-2 private_questions">

                                    </div>
                                    <div class="form-row">
                                        <button type="button" class="btn btn-info m-2 add-row-exam">
                                            <i class="fas fa-plus"></i> Adicionar questões aleatórias
                                        </button>
                                        <button type="button" class="btn btn-secondary m-2" id="add_priv_question">
                                            <i class="fas fa-plus"></i> Adicionar questao personalizada
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
                        <button type="submit" class="btn btn-primary" id="submit-exam">{{isset($exam)?'Salvar':'Gerar'}} Prova</button>
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

    {{-- trumbowyg --}}
    <script src="{{asset('plugins/trumbowyg/trumbowyg.min.js')}}"></script>
    {{-- <script src="trumbowyg/dist/plugins/upload/trumbowyg.cleanpaste.min.js"></script>
    <script src="trumbowyg/dist/plugins/upload/trumbowyg.pasteimage.min.js"></script> --}}
    <script>
        // Doing this in a loaded JS file is better, I put this here for simplicity
        $('#editor').trumbowyg({
            btns: [['strong', 'em',]],
            autogrow: true,
            removeformatPasted: true,
        });
    </script>
@endsection

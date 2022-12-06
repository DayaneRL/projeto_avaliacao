<div class="tab-pane fade" id="Questoes" role="tabpanel" aria-labelledby="questoes-tab">
    <div class="card border-left-primary shadow py-2 mb-3">
        <div class="card-body">
            <div class="row no-gutters align-items-center mb-3">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        questões
                    </div>
                </div>
            </div>

            <div class="form-row tot_questions">
                <div class="form-group col-md-3">
                    <label for="inputTotQuant">Total de questões<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="inputTotQuant" name="exam[number_of_questions]"
                    value="{{$exam->number_of_questions??old('exam.number_of_questions')}}" required>
                </div>
            </div>

        </div>
    </div>

    <div class="card border-left-info shadow py-2 mb-3">
        <div class="card-body">
            <div class="row no-gutters align-items-center mb-3">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        questões aleatórias
                    </div>
                </div>
            </div>

            <div class="exam-attributes mb-4">
                @if(isset($exam->Attributes))
                    @foreach ($exam->Attributes as $key => $attribute)
                    <div class="form-row attribute">
                        <input type="hidden" name="exam_attributes[{{$key}}][id]" value="{{$attribute->id}}">
                        <div class="form-group col-md-3 col-sm-4">
                            <label for="inputQuant">Qtd. de questões <span class="text-danger">*</span></label>
                                <input type="number" class="form-control input-quant" id="inputQuant" name="exam_attributes[{{$key}}][number_of_questions]"
                                value="{{ $attribute->number_of_questions}}" readonly>
                        </div>

                        <div class="form-group col-md-4  col-sm-5">
                            <label for="inputState_0">Nível <span class="text-danger">*</span></label>
                            <select id="inputState_0" class="form-control" name="exam_attributes[{{$key}}][level_id]" readonly>
                                @foreach ($levels as $level)
                                <option value="{{$level->id}}"
                                    @if(old('exam_attributes.0.level_id')==$level->id || $attribute->level_id==$level->id) selected @endif
                                >{{$level->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="form-group col-md-5 pt-3">
                            <button type="button" class="btn btn-primary mt-3 btn-icon-split p-2 pr-3 pl-3 add-row-exam">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-danger mt-3 btn-icon-split p-2 pr-3 pl-3 rm-row-exam {{$key==0?'disabled':''}}" {{$key==0?'disabled':''}}>
                                <i class="fas fa-trash"></i>
                            </button>
                        </div> --}}
                    </div>
                    @endforeach

                    @if(isset($exam_questions))
                        @foreach ($exam_questions as $key=> $exam_question)
                         <hr/>
                        <div class="m-1 exam_question" id="exam_question-{{$exam_question->number}}">
                            <input type="hidden" class="question_id" value="{{$exam_question->id}}"/>
                            <div class="row">
                                <div class="col-md-11">
                                    <p class="questionNumber">Questão {{$exam_question->number}}</p>
                                </div>
                                <div class="col-md-1 d-flex justify-content-end">
                                    <button type="button" class="btn btn-info btn-sm edit-exam_question"><i class="fas fa-pen"></i></button>
                                </div>
                            </div>

                            <label>Descrição </label>
                            <textarea rows="3" class="form-control description_question text-secondary" disabled>@if(isset($exam_question->question->description_read)){{$exam_question->question->description_read}}@endif</textarea>

                            @if (isset($exam_question->question->answers))
                            <div class="row mt-3">
                                @foreach ($exam_question->question->answers as $answer)
                                    <div class="form-group col-md-6 anwers">
                                        <input type="hidden" class="answer_id" value="{{$answer->id}}"/>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text answer_alternative">{{$answer->alternative}}</span>
                                            </div>
                                            <input type="hidden" class="answer_valid" value="{{$answer->valid}}"/>
                                            <input type="text" class="form-control answer_description" value="{{$answer->description}}" disabled/>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach
                    @endif
                @else
                <div class="form-row">
                    <button type="button" class="btn btn-info m-2 add-row-exam">
                        <i class="fas fa-plus"></i> Adicionar questões aleatórias
                    </button>
                </div>
                @endif
                <input type="hidden" id="exam_levels" value="{{$levels}}"/>
            </div>

        </div>
    </div>

    <div class="card border-left-secondary shadow py-2 mb-3">
        <div class="card-body">
            <div class="row no-gutters align-items-center mb-3">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                        questões personalizadas
                    </div>
                </div>
            </div>
            <div class="row mb-2 private_questions">
                @if(isset($questions_private))
                    @foreach ($questions_private as $key=> $question_private)
                    <div class="col-md-12 question mb-2 p-0 border rounded">
                        <input type="hidden" name="private_questions[{{$key}}][id]" value="{{$question_private->id}}"/>
                        <input type="hidden" name="private_questions[{{$key}}][question_private_id]" value="{{$question_private->QuestionsPrivate->id}}"/>
                        <button class="btn btn-secondary border col-md-12 private_toggle" type="button" data-toggle="collapse" data-target="#question-{{$question_private->number}}" aria-expanded="true" aria-controls="question-{{$question_private->number}}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="toggle">
                                    Questão - {{$question_private->number}} <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="btn border py-1 rm-question">
                                    <i class="fas fa-trash" style="color:#fff"></i>
                                </div>
                            </div>
                        </button>
                        <div class="form-row p-3 multi-collapse collapse show" id="question-{{$question_private->number}}">
                            <div class="form-group col-md-12">
                                <label>Descrição da pergunta<span class="text-danger">*</span></label>
                                <textarea class="form-control editor" name="private_questions[{{$key}}][description]">
                                    {{$question_private->QuestionsPrivate->description}}
                                </textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Tipo da resposta<span class="text-danger">*</span></label>
                                <select class="form-control" id="choose-question-type">
                                    <option>Selecione...</option>
                                    <option @if (count($question_private->AnswersPrivate)) selected @endif value="Alternativa">Alternativa</option>
                                    <option value="Descritiva">Descritiva</option>
                                </select>
                            </div>
                            @if (count($question_private->AnswersPrivate))
                                @foreach ($question_private->AnswersPrivate as $key_ans => $answer)
                                <div class="form-group col-md-12 row q_answer">
                                    <input type="hidden" name="private_questions[{{$key}}][answer][{{$key_ans}}][answer_private_id]" value="{{$answer->id}}"/>
                                    <div class="form-group col-md-10">
                                        <label for="inputState_0">Descrição da alternativa <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text alternative_option @if($answer['valid']==1) bg-success @endif"
                                                    @if($answer['valid']==1) style="color:#fff" @endif id="basic-addon1"
                                                >{{$answer['alternative']}}</span>
                                            </div>
                                            <input type="hidden" name="private_questions[{{$key}}][answer][{{$key_ans}}][alternative]" value="{{$answer['alternative']}}"/>
                                            <input type="hidden" class="alternative_valid" name="private_questions[{{$key}}][answer][{{$key_ans}}][valid]" value="{{$answer['valid']}}"/>
                                            <input type="text" class="form-control" name="private_questions[{{$key}}][answer][{{$key_ans}}][description]" aria-describedby="basic-addon1" value="{{$answer['description']}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2 pt-3">
                                        <button type="button" class="btn btn-secondary add_q_answer">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button type="button" class="btn btn-secondary rm_q_answer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                @endforeach
                            @endif
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
            <div class="form-row">
                <button type="button" class="btn btn-secondary m-2" id="add_priv_question">
                    <i class="fas fa-plus"></i> Adicionar questao personalizada
                </button>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary shadow" id="submit-exam" onclick="$('#preview-tab').click()">Gerar</button>
    </div>

</div>

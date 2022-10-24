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
                <input type="hidden" id="exam_levels" value="{{$levels}}"/>
                @endif
            </div>

            <div class="form-row">
                <button type="button" class="btn btn-info m-2 add-row-exam">
                    <i class="fas fa-plus"></i> Adicionar questões aleatórias
                </button>

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

            </div>
            <div class="form-row">
                <button type="button" class="btn btn-secondary m-2" id="add_priv_question">
                    <i class="fas fa-plus"></i> Adicionar questao personalizada
                </button>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary shadow" onclick="$('#preview-tab').click()">Gerar</button>
    </div>

</div>

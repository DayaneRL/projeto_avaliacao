<div class="tab-pane fade show active" id="dadosGerais" role="tabpanel" aria-labelledby="dados-tab">
    <div class="card border-left-primary shadow py-2 mb-4">
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
                    <select class="js-select2 form-control" id="tags" name="exam[tags][]" multiple="multiple">
                        @foreach ($tags as $key => $tag)
                        <option value="{{$tag->id}}-{{$tag->category_id}}"
                            @if(isset($exam)&&in_array($tag->description, $exam->tags_list))
                            selected
                            @endif
                        >
                            {{$tag->description}}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
    </div>
    <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-primary shadow" onclick="$('#questoes-tab').click()">Próximo</button>
    </div>

</div>

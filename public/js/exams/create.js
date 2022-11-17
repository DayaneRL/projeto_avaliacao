$(document).ready(function() {
    $('.js-select2').select2({
        "language": {
            "noResults": function(){
                return "Não encontrou resultados";
            }
        },
    });

    $('#inputData').mask('99/99/9999');
    tagOptions = $('#tags').find('option');
    levels = JSON.parse($('#exam_levels').val());
});

var totalQuestions = $('#inputTotQuant').val()==''? 0 : parseInt($('#inputTotQuant').val());
var sum_questions = 0;
var sum_priv_questions = 0;
var has_empty_field = false;

//beggin - exam-attributes
$(document).on('click', '.add-row-exam', function(){

    let quant_attributes = $('.attribute').length;
    checkFields();
    //ver pq nao ta entrando quando só tem 1 questao
    if(
        totalQuestions>0 &&
        (quant_attributes>=0&&has_empty_field==false)&&
        (sum_questions+sum_priv_questions)<totalQuestions
    ){
        $('.exam-attributes').find('span').remove();
        $('#submit-exam').attr('disabled', false);

        let div =
            `<div class="form-row  rounded attribute">
                <div class="form-group col-md-3">
                    <label for="inputQuant">Qtd. de questões</label>
                    <input type="number" class="form-control input-quant" id="inputQuant" name="exam_attributes[${quant_attributes}][number_of_questions]">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputState_${quant_attributes}">Nível</label>
                    <select id="inputState_${quant_attributes}" class="form-control level_select" name="exam_attributes[${quant_attributes}][level_id]">
                    </select>
                </div>
                <div class="form-group col-md-5 pt-3">
                    <button type="button" class="btn btn-info mt-3 btn-icon-split p-2 pr-3 pl-3 rm-row-exam">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>`;
        $('.exam-attributes').append(div);

        $(levels).each(function(i, e){
            let opt = document.createElement("option");
            $(opt).val(e.id);
            $(opt).text(e.name);
            $('#inputState_'+quant_attributes).append(opt);
        })

    }
    else if(
        sum_questions > totalQuestions && $('.exam-attributes').find('span').length==0
    ){
        $('.exam-attributes').append('<span class="text-danger mb-2">As quantidades de questões ultrapassaram o número Total de questões</span>');
        $('#submit-exam').attr('disabled', true);
        $('.add-row-exam').attr('disabled', true);
    }

    checkTotField();
    checkTotQuestions();
})

$(document).on('click', '.rm-row-exam', function(){
    let div = $(this).parents('.form-row');
    div.slideUp( "slow", function() {
        div.remove();
        checkFields();
        checkTotQuestions();
    });
})

$(document).on('keyup', '.input-quant', function(){
    checkFields();
})

function checkFields(){
    totalQuestions = $('#inputTotQuant').val()==''? 0 : parseInt($('#inputTotQuant').val());
    sum_questions = 0;
    has_empty_field = false;
    sum_priv_questions = $('.question').length;

    $('.input-quant').each(function(i, e){
        sum_questions += $(e).val() != '' ? parseInt($(e).val()) : 0;
        if($(e).val()==''){
            has_empty_field=true;
            $(e).addClass('is-invalid');
            if($(e).parents('.form-group').find('span').length==0){
                $(e).parents('.form-group')
                .append('<span class="text-danger obg">Esse campo é obrigatório</span>');
            }
        }
    })

    if(sum_questions==0){
        $('.input-quant').addClass('is-invalid');
        if($('.exam-attributes').find('span').length===0){
            $('.exam-attributes').append(`
                <span class="text-danger obg">Esse campo é obrigatório</span>
            `)
        }
    }else if(has_empty_field==false){
        $('.input-quant').removeClass('is-invalid');
        $('.exam-attributes').find('span.obg').remove();
    }

    if(
        sum_questions > totalQuestions && $('.exam-attributes').find('span').length==0
    ){
        $('.exam-attributes').append('<span class="text-danger mb-2">As quantidades de questões ultrapassaram o número Total de questões</span>');
        $('#submit-exam').attr('disabled', true);
        $('.add-row-exam').attr('disabled', true);
    }else if(sum_questions == totalQuestions){
        $('.add-row-exam').attr('disabled', true);
        if($('.exam-attributes').find('span')){
            $('.exam-attributes').find('span').remove();
        }
    } else if(sum_questions < totalQuestions && has_empty_field==false){
        $('.exam-attributes').find('span').remove();
        $('#submit-exam').attr('disabled', false);
        $('.add-row-exam').attr('disabled', false);
    }
    console.log(totalQuestions, sum_questions, sum_priv_questions);
    console.log((sum_questions+sum_priv_questions));
}

$(document).on('keyup', '#inputTotQuant', function(){
    checkTotField();
})

function checkTotField(){
    totalQuestions = $('#inputTotQuant').val()==''? 0 : parseInt($('#inputTotQuant').val());

    if(totalQuestions==''){
        $('#inputTotQuant').addClass('is-invalid');
        if($('#inputTotQuant').parents('.form-group').find('span.obg').length===0){
            $('#inputTotQuant').parents('.form-group').append(`
                <span class="text-danger obg">Esse campo é obrigatório</span>
            `)
        }
    }else{
        $('#inputTotQuant').removeClass('is-invalid');
        $('#inputTotQuant').parents('.form-group').find('span.obg').remove();
    }
}
//end - exam-attributes

// Categories - tags
$(document).on('change','#inputCategory', function(){
    let filtered = [];
    $(tagOptions).each( function(i,e) {
        if($(e).val().split('-')[1] == $('#inputCategory').val()){
            filtered.push({
               value: $(e).val().split('-')[1],
               label: $(e).text()
            });
        }
    });
    $('#tags').find('option').remove();
    $(filtered).each( function(i, e){
        $('#tags').append(`<option value="${e.value}">${e.label}</option>`);
    });
});
// Categories - tags

// Beggin - private questions
$(document).on('click','#add_priv_question', function(){

    // let quant_questions = $('.question').length;
    $('.private_questions').find('span.limit-error').remove();
    // checkTotField();
    checkFields();
    if(
        totalQuestions>0 &&
        (sum_questions+sum_priv_questions)<totalQuestions
        )
    {
        let div = `<div class="col-md-12 question mb-2 p-0 border rounded">
            <button class="btn btn-secondary border col-md-12 private_toggle" type="button" data-toggle="collapse" data-target="#question-${sum_priv_questions}" aria-expanded="true" aria-controls="question-${sum_priv_questions}">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="toggle">
                        Questão - ${(sum_priv_questions + 1)} <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="btn border py-1 rm-question">
                        <i class="fas fa-trash" style="color:#fff"></i>
                    </div>
                </div>
            </button>
            <div class="form-row p-3 multi-collapse collapse show" id="question-${sum_priv_questions}">
                <div class="form-group col-md-12">
                    <label>Descrição da pergunta<span class="text-danger">*</span></label>
                    <textarea class="form-control" name="exam[private_questions][${sum_priv_questions}][description]" id="editor"></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label>Imagem</label><br/>
                    <div class="input-group mb-3">
                        <div class="custom-file" id="customFile">
                            <input type="file" class="custom-file-input" id="imagem" name="exam[private_questions][${sum_priv_questions}][image]">
                            <label class="custom-file-label" for="imagem"> Selecionar Arquivo </label>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label>Tipo da resposta<span class="text-danger">*</span></label>
                    <select class="form-control" id="choose-question-type">
                        <option>Selecione...</option>
                        <option value="Alternativa">Alternativa</option>
                        <option value="Descritiva">Descritiva</option>
                    </select>
                </div>
            </div>
        </div>`;
        $('.private_questions').append(div);
        $('#editor').trumbowyg({
            btns: [['strong', 'em',]],
            autogrow: true,
            removeformatPasted: true,
        });
    }else{
        $('.private_questions').append('<span class="limit-error text-danger mb-2">As quantidades ultrapassaram o número Total de questões</span>');
    }

    checkTotQuestions();
})

$(document).on("change","#imagem", function(){
    $(this).parent().find('label').text(this.files[0].name);
})

$(document).on("change","#choose-question-type", function(e){

    $(this).parents('.question').find('.q_answer').remove();
    let quant_questions = $('.question').length -1;

    if($(e.target).val()=="Alternativa"){
        let div = `<div class="form-group col-md-12 row q_answer">
            <div class="form-group col-md-10">
                <label for="inputState_0">Descrição da alternativa <span class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">a)</span>
                    </div>
                    <input type="hidden" name="exam[private_questions][${quant_questions}][answer][alternative]" value="a"/>
                    <input type="number" class="form-control" name="exam[private_questions][${quant_questions}][answer][description]" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="form-group col-md-2 pt-3">
                <button type="button" class="btn btn-secondary add_q_answer">
                    <i class="fas fa-plus"></i>
                </button>
                <button type="button" class="btn btn-secondary disabled rm_q_answer" disabled="true">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>`;
        $(this).parents('.question').find('.form-row').append(div);
    }else if($(e.target).val()=="Descritiva"){
        let div =  `<div class="form-group col-md-6 q_answer">
                        <label> Qtd. de linhas <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="exam[private_questions][${quant_questions}][answer][rows]">
                        <small>Quantidades de linhas disponível para resposta do aluno</small>
                    </div>`;
        $(this).parents('.question').find('.form-row').append(div);
    }
})

$(document).on("click",".add_q_answer", function(){
    let qtd_answers = $('.q_answer').length;
    let alternatives = ['a','b','c','d'];
    let quant_questions = $('.question').length -1;

    if(qtd_answers < 4){
        let div = `<div class="form-group col-md-12 row q_answer">
            <div class="form-group col-md-10">
                <label for="inputState_0">Descrição da alternativa <span class="text-danger">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">${alternatives[qtd_answers]})</span>
                    </div>
                    <input type="hidden" name="exam[private_questions][${quant_questions}][answer][alternative]" value="${alternatives[qtd_answers]}"/>
                    <input type="number" class="form-control" name="exam[private_questions][${quant_questions}][answer][description]" aria-describedby="basic-addon1">
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
        </div>`;
        $(this).parents('.question').find('.form-row').append(div);
        if(qtd_answers==3){
            $(this).parents('.question').find('.add_q_answer').attr('disabled',true);
        }
    }else{
        $(this).parents('.question').find('.add_q_answer').attr('disabled',true);
    }
})

$(document).on("click",".rm_q_answer", function(){
    if($('.q_answer').length <= 4){
        $(this).parents('.question').find('.add_q_answer').attr('disabled',false);
    }
    $(this).parents('.q_answer').remove();
})

$(document).on('click','button.private_toggle',function(){
    if($(this).attr('aria-expanded')=='true'){
        $(this).find('.toggle i').attr('class','fas fa-chevron-down');
    }else{
        $(this).find('.toggle i').attr('class','fas fa-chevron-up');
    }
});

$(document).on('click','.rm-question',function(){
    let div = $(this).parents('.question');
    div.slideUp( "slow", function() {
        div.remove();
        $('.private_questions').find('span.limit-error').remove();
        checkTotQuestions();
    });
})
// End - private questions

function checkTotQuestions(){
    totalQuestions = $('#inputTotQuant').val()==''? 0 : parseInt($('#inputTotQuant').val());
    sum_questions = 0;
    sum_priv_questions = $('.question').length;
    $('.input-quant').each(function(i, e){
        sum_questions += $(e).val() != '' ? parseInt($(e).val()) : 0;
    });
    console.log(totalQuestions,sum_questions,sum_priv_questions);
    if(totalQuestions==(sum_questions+sum_priv_questions)){
        $('.add-row-exam').attr('disabled', true);
        $('#add_priv_question').attr('disabled', true);
    }else{
        $('.add-row-exam').attr('disabled', false);
        $('#add_priv_question').attr('disabled', false);
    }
}

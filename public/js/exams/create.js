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
});

var totalQuestions = $('#inputTotQuant').val()==''? 0 : parseInt($('#inputTotQuant').val());
var sum_questions = 0;

$(document).on('click', '.add-row-exam', function(){
    checkFields();
    // console.log(totalQuestions, sum_questions);
    // console.log($('.exam-attributes').find('span').length);

    if(
        totalQuestions!='' &&
        totalQuestions>1 &&
        sum_questions != 0 &&
        sum_questions<totalQuestions &&
        has_empty_field==false
    ){
        $('.exam-attributes').find('span').remove();
        $('#submit-exam').attr('disabled', false);
        let levels = $('#inputState_0').find('option');
        let quant_attributes = $('.attribute').length;
        let div =
            `<div class="form-row attribute">
                <div class="form-group col-md-3">
                    <label for="inputQuant">Qtd. de questões</label>
                    <input type="number" class="form-control input-quant" id="inputQuant" name="exam_attributes[${quant_attributes}][number_of_questions]">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputState_${quant_attributes}">Nível</label>
                    <select id="inputState_${quant_attributes}" class="form-control level_select" name="exam_attributes[${quant_attributes}][level_id]">
                    </select>
                </div>
                <div class="form-group col-md-3 pt-3">
                    <button type="button" class="btn btn-primary mt-3 btn-icon-split p-2 pr-3 pl-3 add-row-exam">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-danger mt-3 btn-icon-split p-2 pr-3 pl-3 rm-row-exam">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>`;
        $('.exam-attributes').append(div);

        $(levels).each(function(i, e){
            let opt = document.createElement("option");
            $(opt).val($(e).val());
            $(opt).text($(e).text());
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

})

$(document).on('click', '.rm-row-exam', function(){
    $(this).parents('.form-row').remove();

    checkFields();
})

$(document).on('keyup', '.input-quant', function(){
    checkFields();
})

function checkFields(){
    totalQuestions = $('#inputTotQuant').val()==''? 0 : parseInt($('#inputTotQuant').val());
    sum_questions = 0;
    has_empty_field = false;

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

    // console.log(totalQuestions, sum_questions, has_empty_field);

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
    console.log(filtered);
    //each filter substituir options
});

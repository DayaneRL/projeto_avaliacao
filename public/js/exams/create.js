$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});

$(document).on('click', '.add-row-exam', function(){
    let totalQuestions = $('#inputTotQuant').val();
    let sum_questions = 0;
    $('.input-quant').each(function(i, e){
        sum_questions += $(e).val() != '' ? parseInt($(e).val()) : 0;
    })
    console.log(sum_questions);
    if(totalQuestions!=''&&totalQuestions>1&&sum_questions<totalQuestions){
        $('.exam-attributes').find('span').remove();
        $('#submit-exam').attr('disabled', false);

        let levels = $('#inputState').find('option');
        console.log(levels);

        let div =
            `<div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputQuant">Qtd. de questões</label>
                    <input type="number" class="form-control input-quant" id="inputQuant" name="exam[number_of_questions]">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputState">Nível</label>
                    <select id="inputState" class="form-control" name="exam_attributes[level_id]">
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
    }
    else if(sum_questions > totalQuestions &&
        $('.exam-attributes').find('span').length===0){
        $('.exam-attributes').append(`<span class="text-danger mb-2">As quantidades
        de questões ultrapassaram o número Total de questões</span>`);
        $('#submit-exam').attr('disabled', true);
        $('.add-row-exam').attr('disabled', true);
    }
})

$(document).on('click', '.rm-row-exam', function(){
    $(this).parents('.form-row').remove();
})

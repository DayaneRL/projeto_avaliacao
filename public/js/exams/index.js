$(document).on('click','.show_exam', function(){
    let category = $(this).parents('tr').find('.exam_category').text();
    let level = $(this).parents('tr').find('.exam_level').text();
    let date = $(this).parents('tr').find('.exam_date').text();

    $('#showModal').find('#showModalLabel').text('name prova');
    if($('#showModal').find('.modal-body').find('.row')){
        $('#showModal').find('.modal-body').find('.row').remove();
    }
    $('#showModal').find('.modal-body').append(`
    <div class="row no-gutters align-items-center mb-3">
        <div class="col-12 text-center">
            <p><b>Qtd. questões:</b> 10 </p>
            <p><b>Categoria:</b> ${category} </p>
            <p><b>Nível:</b> ${level} </p>
            <p><b>Data Cadastro:</b> ${date} </p>
            <div class="mt-2">
                <button type="button" class="btn btn-primary btn-icon-split p-2">
                    <i class="fas fa-file-download mr-2 pt-1"></i> Prova
                </button>
                <button type="button" class="btn btn-primary btn-icon-split p-2">
                    <i class="fas fa-file-download mr-2 pt-1"></i> Gabarito
                </button>
            </div>
        </div>
    </div>
    `);

    $('#showModal').modal('show');
})

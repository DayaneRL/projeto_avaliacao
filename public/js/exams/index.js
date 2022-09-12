$(document).on('click','.show_exam', function(){
    let id = $(this).parents('tr').find('.exam_id').text();

    $('#examModalLabel').text('Dados da prova');

    $('#examModal').find('.content').remove();
    $('#examModal').find('.modal-body').append(`
        <div class="content text-center">
            <img src="/img/Book.gif" alt="loading gif" id="loading">
        </div>
    `);
    $('#examModal').modal('show');

    $.ajax({
        url: `/findExam/${id}`,
        type: 'GET',
        success: function (response) {

            let exam = response.exam;
            let category = response.category;
            $('#examModal').find('.modal-body').find('.content').remove();

            $('#examModal').find('.modal-body').append(`
                <div class="content text-center">
                    <h3 id="exam_title">${exam.title}</h3>
                    <p id="exam_tags"><b>Tags:</b> ${exam.tags} </p>
                    <p id="exam_total"><b>Total de questões:</b> ${exam.number_of_questions} </p>
                    <p id="exam_categoria"><b>Categoria:</b> ${category.name} </p>
                    <p id="exam_data"><b>Data da prova:</b> ${response.exam_date} </p>
                    <p><b>Níveis:</b> ${response.levels} </p>
                    <hr/>
                    <div class="mt-2">
                        <button type="button" class="btn btn-info p-2">
                        <i class="fas fa-download mr-2 ml-1"></i> prova
                        </button>
                        <button type="button" class="btn btn-warning p-2">
                        <i class="fas fa-download mr-2 ml-1"></i> gabarito
                        </button>
                    </div>
                </div>
            `);

            $('#examModal').find('.modal-footer').find('.btn-primary').remove();
            $('#examModal').find('.modal-footer').prepend(`
                <a href="/exams/${id}" class="btn btn-primary">Visualizar</a>
            `);

        },
        error: function (error) {
            console.log(error);
        }
    });

})


$(document).on('click', '.btn-delete', function(){
    let exam_id = $(this).parents('tr').find('.exam_id').text();
    let title = $(this).parents('tr').find('.exam_title').text();

    $('#examModalLabel').text('Excluir Prova');
    $('#examModal').find('.modal-body').find('.content').text(`
    Deseja realmente excluir: ${title} ?`);

    $('#examModal').find('.modal-footer').find('.btn-primary').remove();
    $('#examModal').find('.modal-footer').find('.btn-danger').remove();
    $('#examModal').find('.modal-footer').prepend(`
        <button type="button" class="btn btn-danger btn-confirm" id="rm_exam_${exam_id}">Excluir</button>
    `);

    $('#examModal').modal('show');
})

$(document).on('click','.btn-confirm', function(){
    let id = $(this).attr('id').split('_')[2];
    $(this).attr('disabled',true);

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        url: `/exams/${id}`,
        type: 'DELETE',
        success: function (response) {
            $('#exam_id_'+id).parents('tr').find('td').slideUp('slow');
        },
        error: function (error) {
            console.log(error);
        }
    });

    $('#examModal').modal('hide');
})

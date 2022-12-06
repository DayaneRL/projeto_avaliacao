$(document).on('click','.show_exam', function(){
    let id = $(this).parents('tr').find('.exam_id').text();

    $('#utilsModalLabel').text('Dados da prova');

    $('#utilsModal').find('.content').remove();
    $('#utilsModal').find('.modal-body').append(`
        <div class="content text-center">
            <img src="/img/Book.gif" alt="loading gif" id="loading">
        </div>
    `);

    $('#utilsModal').find('.modal-footer').children().remove();
    $('#utilsModal').find('.modal-footer').prepend(`
        <a href="/exams/${id}" class="btn btn-primary">Visualizar</a>
        <button type="button" class="btn btn-light border" data-dismiss="modal">Cancelar</button>
    `);

    $('#utilsModal').modal('show');

    $.ajax({
        url: `/findExam/${id}`,
        type: 'GET',
        success: function (response) {
            console.log(response);
            let exam = response.exam;
            $('#utilsModal').find('.modal-body').find('.content').remove();

            $('#utilsModal').find('.modal-body').append(`
                <div class="content text-center">
                    <div class="d-none" id="id_exam">${id}</div>
                    <h3 id="exam_title">${exam.title}</h3>
                    <p id="exam_tags"><b>Tags:</b> ${response.tags_list} </p>
                    <p id="exam_total"><b>Total de questões:</b> ${exam.number_of_questions} </p>
                    <p id="exam_categoria"><b>Categoria:</b> ${exam.category.name} </p>
                    <p id="exam_data"><b>Data da prova:</b> ${response.exam_date} </p>
                    <hr/>
                    <div class="mt-2">
                        <button type="button" class="btn btn-info p-2" onclick="downloadTest()">
                        <i class="fas fa-download mr-2 ml-1" ></i> prova
                        </button>
                        <button type="button" class="btn btn-warning p-2"  onclick="downloadAnswers()">
                        <i class="fas fa-download mr-2 ml-1"></i> gabarito
                        </button>
                    </div>
                </div>
            `);

        },
        error: function (error) {
            console.log(error.responseJSON);
        }
    });

})


$(document).on('click', '.btn-delete', function(){
    let exam_id = $(this).parents('tr').find('.exam_id').text();
    let title = $(this).parents('tr').find('.exam_title').text();

    $('#utilsModalLabel').text('Excluir Prova');

    $('#utilsModal').find('.modal-body').find('.content').children().remove();
    $('#utilsModal').find('.modal-body').find('.content').append
    (`<p>Deseja realmente excluir: <b>${title}</b> ?</p>`);

    $('#utilsModal').find('.modal-footer').children().remove();
    $('#utilsModal').find('.modal-footer').prepend(`
        <button type="button" class="btn btn-danger btn-confirm" id="rm_exam_${exam_id}">Excluir</button>
        <button type="button" class="btn btn-light border" data-dismiss="modal">Cancelar</button>
    `);

    $('#utilsModal').modal('show');
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

    $('#utilsModal').modal('hide');
})


function downloadTest() {
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        url: "/exams/download_exam",
        type: 'POST',
        data: {
            title: $('#exam_title').text(),
            id: $('#id_exam').text()
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function(response) {
            var blob = new Blob([response]);
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = $('#exam_title').text()+'.pdf';
            link.click();
        },
        error: function(blob) {
            console.log(blob);
        }
    });
}

function downloadAnswers() {
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        url: "exams/download_answers",
        type: 'POST',
        data: {
            title: $('#exam_title').text(),
            id: $('#id_exam').text()
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function(response) {
            var blob = new Blob([response]);
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'Gabarito da '+$('#exam_title').text()+'.pdf';
            link.click();
        },
        error: function(blob) {
        }
    });
}

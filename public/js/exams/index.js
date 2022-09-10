$(document).on('click','.show_exam', function(){
    let id = $(this).parents('tr').find('.exam_id').text();

    $('#examModal').find('.content').remove();
    $('#examModal').find('.modal-body').append(`
        <div class="content text-center">
            <img src="/img/Book.gif" alt="loading gif" id="loading">
        </div>
    `);
    $('#examModal').modal('show');

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
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

            $('#examModal').find('.modal-footer').prepend(`
                <a href="/exams/${id}" class="btn btn-primary">Visualizar</a>
            `);

        },
        error: function (error) {
            console.log(error);
        }
    });

})

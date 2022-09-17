$(document).on('click','.show_header', function(){
    let id = $(this).parents('tr').find('.header_id').text();

    $('#examModalLabel').text('Dados do cabeçalho');
    $('#headerModal').find('.content').remove();
    $('#headerModal').find('.modal-body').append(`
        <div class="content text-center">
            <img src="/img/Book.gif" alt="loading gif" id="loading">
        </div>
    `);
    $('#headerModal').modal('show');

    $.ajax({
        url: `/findHeader/${id}`,
        type: 'GET',
        success: function (response) {

            $('#headerModal').find('.modal-body').find('.content').remove();

            $('#headerModal').find('.modal-body').append(`
                <div class="content text-center">
                    <h3>${response.header.description}</h3>
                    <p><b>Data de cadastro:</b> ${response.header.date} </p>
                    <img src='${response.header.logo}' alt='${response.header.description}'/>
                </div>
            `);

        },
        error: function (error) {
            console.log(error);
        }
    });

})


$(document).on('click', '.btn-delete', function(){
    let header_id = $(this).parents('tr').find('.header_id').text();

    $('#examModalLabel').text('Excluir cabeçalho');
    $('#headerModal').find('.modal-body').find('.content').text(`
    Deseja realmente excluir ?`);

    $('#headerModal').find('.modal-footer').find('.btn-danger').remove();
    $('#headerModal').find('.modal-footer').prepend(`
        <button type="button" class="btn btn-danger btn-confirm" id="rm_header_${header_id}">Excluir</button>
    `);

    $('#headerModal').modal('show');
})

$(document).on('click','.btn-confirm', function(){
    let id = $(this).attr('id').split('_')[2];
    $(this).attr('disabled',true);

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        url: `/headers/${id}`,
        type: 'DELETE',
        success: function (response) {
            $('#header_id_'+id).parents('tr').find('td').slideUp('slow');
        },
        error: function (error) {
            console.log(error);
        }
    });

    $('#headerModal').modal('hide');
})

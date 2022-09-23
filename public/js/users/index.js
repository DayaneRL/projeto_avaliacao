$(document).on('click', '.btn-delete', function(){
    let user_id = $(this).parents('tr').find('.user_id').text();
    let name = $(this).parents('tr').find('.user_name').text();

    $('#deleteModalLabel').text('Excluir cabeçalho');
    $('#deleteModal').find('.modal-body').find('.content').append(`<p>Deseja realmente excluir <b>${name}</b>?</p>`);

    $('#deleteModal').find('.modal-footer').find('.btn-danger').remove();
    $('#deleteModal').find('.modal-footer').prepend(`
        <button type="button" class="btn btn-danger btn-confirm" id="rm_delete_${user_id}">Excluir</button>
    `);

    $('#deleteModal').modal('show');
})


$(document).on('click','.btn-confirm', function(){
    let id = $(this).attr('id').split('_')[2];
    $(this).attr('disabled',true);

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() },
        url: `/users/${id}`,
        type: 'DELETE',
        success: function (response) {
            $('#user_id_'+id).parents('tr').find('td').slideUp('slow');
        },
        error: function (error) {
            console.log(error);
        }
    });

    $('#deleteModal').modal('hide');
})


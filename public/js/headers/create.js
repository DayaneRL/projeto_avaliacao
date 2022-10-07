$(document).ready(function () {

    var url = '';
    loadCroppie();

    if($('#logo').length){
        $('.cr-image').attr('src',$('#logo').val());
        $('#image_demo').removeClass('d-none');
    }

    $('#upload_image').on('change', function () {
        $image_crop.croppie('destroy');
        loadCroppie();
        var reader = new FileReader();
        reader.onload = function (event) {
            $('#image_demo').removeClass('d-none');
            $image_crop.croppie('bind', {
                url: event.target.result,
                zoom: 0
            });
            url = event.target.result;
        }
        reader.readAsDataURL(this.files[0]);
    });

    $image_crop.on('update.croppie', function (ev, data) {
        $('#add_img').text(' Editar');
        $('#add_img').prepend('<i class="fas fa-pen"></i>');
        if($('#add_img').parent().find('.btn-danger').length===0){
            $('#add_img').parent().append('<button type="button" class="btn btn-danger ms-2" id="rm_img"><i class="fas fa-trash"></i> Remover</button>');
        }
    });

});

function loadCroppie(){
    $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
            width: 250,
            height: 200,
            type: 'square' //circle
        },
        boundary: {
            width: 300,
            height: 250
        },
        enableResize: true,
        mouseWheelZoombool: false
    });
}

$(document).on('click','#add_img', function(){
    $(this).parent().find('input').click();
})

$(document).on('click','#rm_img', function(){
    $image_crop.croppie('destroy');
    $('#image_demo').addClass('d-none');
    $(this).remove();
    $('#add_img').text(' Adicionar');
    $('#add_img').prepend('<i class="fas fa-plus"></i>');
})

$(document).on('click', '#send_header', function(){

    $image_crop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function (response) {

        let isUpdate = false;
        if($('input[name="_method"]').length){
            isUpdate = true;
            id = $('#header_id').val();
        }

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() },
            url: (isUpdate) ? '/headers/'+id : '/headers',
            type: (isUpdate) ? 'PUT' : 'POST',
            data: {
                '_token':$('input[name="_token"]').val(),
                header:{
                    'description':$('input[name="header[description]"]').val(),
                    'logo': response
                }
            },
            success: function (response) {
                window.location.replace('/headers');
                // console.log(response);
            },
            error: function (error) {
                console.log(error);
                $('.card-body').prepend(`
                    <div class="alert alert-warning">
                        ${error.msg}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `);
            }
        });
    });
})

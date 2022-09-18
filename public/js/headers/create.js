$(document).ready(function () {

    var url = '';
    $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
            width: 300,
            height: 300,
            type: 'square' //circle
        },
        boundary: {
            width: 600,
            height: 400
        }
    });

    $('#upload_image').on('change', function () {
        var reader = new FileReader();
        reader.onload = function (event) {
            $('#uploadimageModal').modal('show');
            $image_crop.croppie('bind', {
                url: event.target.result
            }).then(function () {
                console.log('Imagem selecionada');
            });
            url = event.target.result;
        }
        reader.readAsDataURL(this.files[0]);
        $('.crop_image').attr('disabled', false);
    });

    $('.crop_image').click(function (event) {
        $('.crop_image').attr('disabled', true);
        //tirar previa e enviar croppado somente quando for edição

        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (response) {
            // $.ajax({
            //     headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() },
            //     url: `/updateLogo`,
            //     type: "post",
            //     data: {"id":$('#header_id').val(),"logo": response},
            //     success: function (data)
            //     {
            //         console.log(data);
            //         $('#uploadimageModal').modal('hide');
            //     }
            // });
        })

        $image_crop.croppie('result', {
            type: 'rawcanvas',
            circle: false,
            format: 'png'
        }).then(function (canvas) {
            $('#uploadimageModal').modal('hide');
            $('.img-preview').attr('src', canvas.toDataURL());
            $('#add_img').find('i').attr('class','fas fa-pen');
        });
    });

    $image_crop.on('update.croppie', function (ev, data) {
        $image_crop.croppie('result', {
            type: 'rawcanvas',
            circle: false,
            format: 'png'
        }).then(function (canvas) {
            $('#prev-img').attr('src', canvas.toDataURL());
        });
    });

});


$(document).on('click','#add_img', function(){
    $(this).parent().find('input').click();
})

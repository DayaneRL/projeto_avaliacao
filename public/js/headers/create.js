$(document).ready(function () {

    var url = '';
    $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
            width: 300,
            height: 250,
            type: 'square' //circle
        },
        boundary: {
            width: 350,
            height: 300
        },
        showZoomer: true,
        enableResize: true,
        mouseWheelZoom: 'ctrl',
        maxZoom: 900
    });

    $('#upload_image').on('change', function () {
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
        // $image_crop.croppie('result', {
        //     type: 'blob',
        // }).then(function (blob) {
            $('#add_img').text(' Editar');
            $('#add_img').prepend('<i class="fas fa-pen"></i>');
        // });
    });

});


$(document).on('click','#add_img', function(){
    $(this).parent().find('input').click();
})


$(document).on('click', '#send_header', function(){
    //ajax
    $image_crop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function (response) {
        console.log(response);
    });
})

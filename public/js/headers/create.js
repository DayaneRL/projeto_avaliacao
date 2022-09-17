$(document).ready(function(){
    loadCroppie();
})

function loadCroppie(){
    $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'square'
        },
        boundary: {
            width: 230,
            height: 230
        }
    });
}

$(document).on('change','#upload_image', function () {
    var reader = new FileReader();
    reader.onload = function (event) {
        result = event.target.result;
        arrTarget = result.split(';');
        tipo = arrTarget[0];
        $('#uploadimageModal').modal('show');
        $image_crop.croppie('bind', {
            url: event.target.result
        });
    }
    reader.readAsDataURL(this.files[0]);
});

$(document).on('click','.crop_image',function (event) {
    $image_crop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
    }).then(function (response) {
        //ajax
    })
});


$(document).on('click','#add_img', function(){
    $(this).parent().find('input').click();
})

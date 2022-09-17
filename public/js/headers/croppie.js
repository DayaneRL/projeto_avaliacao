$(document).ready(function(){
    loadCroppie();
})

function loadCroppie(){
    $uploadCrop = $('#upload-image').croppie({
        enableExif: true,
        viewport: {
            width: 250,
            height: 250,
            type: 'square'
        },
        boundary: {
            width: 280,
            height: 280
        }
    });
}


$(document).on('change','#upload_image', function () {
	var reader = new FileReader();
    reader.onload = function (e) {
    	$uploadCrop.croppie('bind', {
    		url: e.target.result
        })
        .then(function(){
            console.log('imagem carregada');
    	});
    }

    reader.readAsDataURL(this.files[0]);
});


$(document).on('click','.upload_image', function (ev) {
	$uploadCrop.croppie('result', {
		type: 'canvas',
		size: 'viewport'
	}).then(function (resp) {

        // let id= $('#id_user').val();
        // let token =  $("[name=_token]").val();
        // let imagem = $('#imagem');
        // $.ajax({
            // url: window.location.origin+"/user/"+id+"/imagem/upload",
            // type: "PATCH",
            // data: {'_token': token,'file': resp},
            // success: function (data) {
            //     console.log(data.deucerto)
            //     $('#modal_image').find('.close').click();
            //     $('.profile-user-img').attr('src', window.location.origin+'/storage/categories/'+data.nomeCriado);

            //     $('.card').before('<div class="alert-success alert-success-box mb-3">'+data.deucerto+'</div>')
            //     $('.alert-success-box').fadeTo(1500, 500).slideUp(400);
            // }
        // });
    });
});

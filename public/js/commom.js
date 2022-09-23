$(document).ready(function() {
    $('.alert').fadeTo(2000, 500).slideUp(500);
});

$(document).on('click', '#logout_system_confirm', async function(){
    $('#logout-form').submit();
})

$(document).ready(function() {
    let div = $('.alert');
    div.slideUp( "slow", function() {
        div.remove();
    });
});

$(document).on('click', '#logout_system_confirm', async function(){
    $('#logout-form').submit();
})

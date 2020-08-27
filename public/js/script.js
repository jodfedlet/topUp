
function showForgotModal(e){
    e.preventDefault();
    $("#login").modal('hide')
    $("#forgot").modal('show')
}

$(window).on('scroll', function(){
    if ($(window).scrollTop()){
      $('nav').addClass('sticky');
    } else{
      $('nav').removeClass('sticky');
    };
});

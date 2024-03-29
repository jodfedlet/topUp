$.ajaxSetup({

    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').prop('content')
    },

    beforeSend: showLoader,
    complete: hideLoader
});

function showLoader() {
    $("#loader").show();
}

function hideLoader() {
    $("#loader").hide();
}

function notificationToast(message, type, redirect) {
    toastr.options = {
        'timeout': 1,
        'positionClass':'toast-top-center'
    };

    if(redirect !== null){
        toastr.options.onHidden = function() {
            window.location.href = window.location.href = redirect;
        };
    }

    if(type === 'error'){
        toastr.error(message);
    }else if(type === 'success'){
        toastr.success(message);
    }else if(type === 'info'){
        toastr.info(message);
    }
}

function showError(idError, message){
    idError.style.display = "block";
    idError.innerHTML = message;
    countErrors++;
}

function hideError(idError){
    idError.style.display = "none";
}
$(document).ready(function(){

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;

    $(".next").click(function(){

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

//Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

//show the next fieldset
        next_fs.show();
//hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now) {
// for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({'opacity': opacity});
            },
            duration: 600
        });
    });

    $(".previous").click(function(){

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

//Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

//show the previous fieldset
        previous_fs.show();

//hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now) {
// for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({'opacity': opacity});
            },
            duration: 600
        });
    });

    $('.radio-group .radio').click(function(){
        $(this).parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
    });

    $(".submit").click(function(){
        return false;
    })

});

jQuery(function ($) {

    $(".sidebar-dropdown > a").click(function() {
        $(".sidebar-submenu").slideUp(200);
        if (
            $(this)
                .parent()
                .hasClass("active")
        ) {
            $(".sidebar-dropdown").removeClass("active");
            $(this)
                .parent()
                .removeClass("active");
        } else {
            $(".sidebar-dropdown").removeClass("active");
            $(this)
                .next(".sidebar-submenu")
                .slideDown(200);
            $(this)
                .parent()
                .addClass("active");
        }
    });

    $("#close-sidebar").on('click',function() {
        //alert('Teste')
        $(".page-wrapper").removeClass("toggled");
    });
});

function showSidebar(){
    $(".page-wrapper").addClass("toggled");
}

function hideSidebar(x) {
    if (x.matches) {
        $(".page-wrapper").removeClass("toggled");
    }
}

let x = window.matchMedia("(max-width: 700px)")
hideSidebar(x)
x.addListener(hideSidebar)

function onlyNumber(z) {
    let v = z.value;
    v=v.replace(/\D/g,"") // permite digitar apenas numero
    z.value = v;
}

$("#reload-page").on('click',function () {
    window.location.href ='/adm'
})


$(document).ready(function(){
    if ( $.fn.dataTable.isDataTable( '#table' ) ) {
        let table = $('#table').DataTable();
    }
    else {
        let table = $('#table').DataTable( {
            scrollY:  250,
            deferRender:    true,
            scroller:       true,
            responsive:true,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json"
            }
        } );
    }
});


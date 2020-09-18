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

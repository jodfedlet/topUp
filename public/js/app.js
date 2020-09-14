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

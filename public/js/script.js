countErrors = 0;
function showForgotModal(e){
    e.preventDefault();
    $("#login").modal('hide')
    $("#forgot").modal('show')
}

function showCreateModal(e){
    e.preventDefault();
    $("#login").modal('hide')
    $("#create").modal('show')
}

function showLoginModal(e){
    e.preventDefault();
    $("#create").modal('hide')
    $("#login").modal('show')
}

$(window).on('scroll', function(){
    if ($(window).scrollTop()){
      $('nav').addClass('sticky');
    } else{
      $('nav').removeClass('sticky');
    };
});

$('#pn_form').submit(function (e) {
    $('button[type="submit"] i').toggleClass('d-none')
    e.preventDefault();
    let phone = $('#phone_number').val();
    let country = $('#country').val();

    $.ajax({
        type: 'GET',
        url: 'countries/'+country+'/operators/detect/'+phone,
        success: function (operator) {

            if(!operator){
                console.log('teste chegando como o esperado');
                return
            }

            $('button[type="submit"] i').toggleClass('d-none')

            $('#details_box').removeClass('d-none');
            $('#details_box').addClass('d-flex');

            if (typeof operator.errorCode !== 'undefined' || typeof operator.error !== 'undefined'){
                $('.operator_detail').addClass('d-none');
                $('#operator_name').html(
                    typeof operator.errorCode !== 'undefined' ? operator.errorCode:operator.error
                );
                $('#operator_id').html('');
                $('#operator_image').prop('src','');

                $('#tu_form').addClass('d-none');
                $('#tu_form input[name="phone_number"]').val('');
                $('#tu_form input[name="country_code"]').val('');
                $('#tu_form input[name="operator_id"]').val(-1);

                $('#tu_form label[for="amount"]').html('Amount');

            }
            else {

                $('.operator_detail').removeClass('d-none');
                $('#operator_name').html(operator.name);
                $('#operator_id').val(operator.rid);
                $('#operator_image').prop('src',operator.logo_urls[0]);

                $('#tu_form').removeClass('d-none');
                $('#tu_form input[name="phone_number"]').val(phone);
                $('#tu_form input[name="country_code"]').val(country);
                $('#tu_form input[name="operator_id"]').val(operator.rid);

                $('#sender_currency').html(operator.sender_currency_code)

                $('#base_amount').html((operator.fx_rate - operator.fx_rate*0.11).toFixed(4)+ " " + operator.destination_currency_code + " / " + operator.sender_currency_code)
                $('#btn-sent-topup').prop('disabled', true);
                if (operator.denomination_type === 'RANGE') {
                    $('#tu_form label[for="amount"]').html('Range Supported Min [' + operator.min_amount + '] Max [' + operator.max_amount + ']');
                }
                else {
                    $('#tu_form label[for="amount"]').html('Fixed Amounts Supported [' + operator.fixed_amounts.toString() + ']');
                }
            }
        }
    })
});

function updateValue(val){
    let base_amount = parseFloat($('#base_amount').html().split(' ')[0])
    let newValue = val.value
    if(newValue > 0) {
        let total = base_amount * newValue;
        total = total.toFixed(4);
        $('#sent_amount').removeClass('d-none');
        $('#btn-sent-topup').prop('disabled', false);
        $('#sent_amount').html(total +' '+ $('#base_amount').html().split(' ')[1])
    }
    else{
        $('#sent_amount').addClass('d-none');
        $('#btn-sent-topup').prop('disabled', true);
        $('#sent_amount').html(base_amount +' '+ $('#base_amount').html().split(' ')[1])
    }
}

function hideOption(field){
    let number = field.value
    if(typeof number === "undefined" || number === ""){
        $('#base_amount_div').addClass('d-none');
        $('#operator_name').addClass('d-none');
        $('#operator_image').addClass('d-none');
        $('#tu_form').addClass('d-none');
    }
}

$(document).ready(function () {
    $("#amount").val('')
})

function getCheckout(event, clientID){
    event.preventDefault();
    let amount = $('#amount').val();

    if(clientID === 0){
       return showLoginModal(event);
    }

    let data = {
        total:$("#amount").val(),
        phone_number:$("#phone_number").val(),
        sent_amount:$("#sent_amount").html().split(' ')[0],
        destination_currency:$('#base_amount').html().split(' ')[1],
        sender_currency:$('#sender_currency').html(),
        country_code: $('#country').val(),
        operator_id: $('#operator_id').val(),
        amountSend:parseFloat(amount - amount* 0.11)
    }
    window.location.href ="/checkout?data="+window.btoa(JSON.stringify(data));
}

function submitPayment(event) {
    event.preventDefault();
    let $credicardForm = document.getElementById('creditCard');

    let audience = false;
    let apiKey = '';
    if(audience){
        apiKey = 'pk_live_Mc21KiZnxtFKhWhUj6f2Lu0v00MshWza1a';
    }else{
        apiKey = 'pk_test_J6gPNcDYWf5gk1p9BEFA54np00o6s0t6bU';
    }

    Stripe.setPublishableKey(apiKey);

    Stripe.card.createToken($credicardForm, function(status, response) {

        if (response.error){
            $('#cc-response').html(response.error.message);
            $('#cc-response').css("color","red");
            $('#cc-response').addClass('text-center');
        }
        else{
            $('#stripeToken').val(response.id)
            $credicardForm.submit();
        }
    });
}

function endRequest(event) {
    event.preventDefault();

    let amount = $('#amount').val();
    let phone_number = $('#phone_number').val();
    let country_code = $('#country').val();
    let operator_id = $('#operator_id').val();
    let amountSend = parseFloat(amount - amount* 0.11);

    let data = {
        amountToSend:amountSend,
        phoneNumber:phone_number,
        countryCode:country_code,
        operatorId:operator_id
    }

    $.post('/checkout', data, function (response) {
        response = JSON.parse(response)

        if(typeof response.errorCode !== "undefined" && response.errorCode !== ""){
            console.warn(response.message)
        }
        else{
            $('#receipt').removeClass('d-none');
            $('#home-page').addClass('d-none');
            $("#operatorName").html(response.operatorName)
            $("#recipientPhone").html(response.recipientPhone)
            $("#rec_sent_amount").html(amount+ " " + response.requestedAmountCurrencyCode)
            $("#deliveredAmount").html(response.deliveredAmount+ " " + response.deliveredAmountCurrencyCode)
        }
    });
}


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').prop('content')
    }
});

function showError(idError, message){
    idError.style.display = "block";
    idError.innerHTML = message;
    countErrors++;
}

function hideError(idError){
    idError.style.display = "none";
}


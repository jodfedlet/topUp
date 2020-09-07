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
    let countryId = $('#country').find('option:selected').attr("data-countryId");

    $.ajax({
        type: 'GET',
        url: 'countries/'+country+'/operators/detect/'+phone,
        success: function (operator) {

            if(!operator){
                $.ajax({
                    type: 'GET',
                    url: 'countries/'+countryId+'/operators',
                    success: function (operators) {
                        let options = '<option value=""></option>';
                        for (let i = 0; i < operators.length; i++) {
                            let log = JSON.parse(operators[i].logo_urls);
                            options += '<option value="' + operators[i].id + '" data-operator-flag="'+log[0]+'">' + operators[i].name + '</option>';
                        }
                        $('#select-operators').modal('show');
                        $('#operator').html(options);
                    }
                })
            }
            else{
                createTopupElement(operator);
            }

           /* $('button[type="submit"] i').toggleClass('d-none')

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
            }*/
        }
    })
});

function submitOperator(event){
    event.preventDefault();
   let operatorId = $('#operator').val();

   if(typeof operatorId !== 'undefined' && operatorId !== ''){
       $.ajax({
           type: 'GET',
           url: 'operator/'+operatorId,
           success: function (operator) {
               $('#select-operators').modal('hide');
               createTopupElement(operator);
           }
       })
   }
}

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
        localStorage.setItem('local','checkout')
       return showLoginModal(event);
    }

    localStorage.setItem('local','')

    let data = {
        total:$("#amount").val(),
        phone_number:$("#phone_number").val(),
        sent_amount:$("#sent_amount").html().split(' ')[0],
        destination_currency:$('#base_amount').html().split(' ')[1],
        sender_currency:$('#sender_currency').html(),
        country_code: $('#country').val(),
        operator_id: $('#operator_id').html(),
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

function createTopupElement(operator) {
   /* console.table(operator)
    return*/
    $('#home-page').addClass('d-none')
    let phone = $('#phone_number').val();
    let countryName = $('#country').find('option:selected').attr("name");
    let ddi = $('#country').find('option:selected').attr("data-ddi");
    let countryFlag = $('#country').find('option:selected').attr("data-country-flag");
    operator.phone = phone;
    operator.countryName = countryName;
    operator.ddi = ddi;
    operator.flag = countryFlag;
    let div = document.createElement("div")
    document.body.appendChild(div)

    if (operator.denomination_type === 'FIXED') {
        $('#range-value-form').hide()
    }
    div.innerHTML = `
    <section role="main" class="flex-shrink-0">
        <div class="container pt-5 mt-5">
<div class="container topupElement">
    <div class="topupElement-content">
                    <div class="row justify-content-center align-items-center">
                        <div class="country">
                            <label><b>Country: </b></label>
                            <span id="operator_name">${operator.countryName}</span>
                            <img src="${operator.flag}">
                            <a  onsubmit="showAllCountry()"><i class="far fa-edit"></i></a>
                        </div>
                        <div class="col-12 text-center" id="operator-detail">
                            <label><b>Operator: </b></label>
                             <span id="operator_name">${operator.name}</span>
                             <img id="operator_image" src="${operator.logo_urls[0]}" width="55px" height="20px">
                        </div><br>

                        <div>
                           <label><b>Phone number:</b></label>
                            <span id="operator_name">${operator.ddi + '' + operator.phone}</span>
                       </div>
                    </div>
                <div class="col-12">
                    <form
                    id="range-value-form"
                        onsubmit="getCheckout(event,${operator.userId})"
                    >
                        <input type="hidden" name="phone_number" value="">
                        <input type="hidden" name="country_code"  value="">

                        <div class="form-group row">
                            <label for="amount" class="w-100">Amount</label>
                            <input type="number" step="0.01" min="0" class="form-control col" id="amount" name="amount" placeholder="Enter amount" required oninput="updateValue(this)">
                        </div>
                        <div class="form-group row " id="base_amount_div">
                            <p>Amount base: <span id="base_amount">${(operator.fx_rate - operator.fx_rate*0.11).toFixed(4)+ ' ' + operator.destination_currency_code + ' / ' + operator.sender_currency_code}</span></p>
                        </div>
                        <div class="form row">
                            <input type="text" class="form-control col d-none" id="receive_amount" name="receive_amount"><br>
                            <p class="d-none" id="sent_amount"></p><br>
                            <p class="d-none" id="sender_currency">${operator.sender_currency_code}</p>
                            <p class="d-none" id="operator_id">${operator.rid}</p>
                        </div><br>
                        <button type="submit" class="btn btn-primary pull-right" id="btn-sent-topup"><i class="fa fa-spinner fa-spin d-none"></i> Pay</button>
                    </form>
                </div>
                </div>
</div>
</div>
</section>
    `
}

function showAllCountry() {
    alert('Teste')
}

function getDataOfCountry(){
    let countryField = $('#country');
    $('#country_flag').prop('src',countryField.find('option:selected').attr("data-country-flag"));
    $('#country-code').html(countryField.find('option:selected').attr("data-ddi"));
}

function getOperatorFlag(){
    $('#operator_flag').prop('src',$('#operator').find('option:selected').attr("data-operator-flag"));
}

$(window).on('load',function () {
    getDataOfCountry();
})



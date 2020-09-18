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
    // $('button[type="submit"] i').toggleClass('d-none')
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
            url: '/operator/'+operatorId,
            beforeSend:showLoader(),
            success: function (operator) {
                $('#select-operators').modal('hide');
                createTopupElement(operator);
            }
        })
    }
}

function updateValue(val){
    $('#btn-sent-topup').addClass('d-none');
    $('#sent_amount').addClass('d-none');
    let newValue = val.value
    if(newValue > 0) {
        $.ajax({
            type: 'post',
            url: '/operator/fxRate',
            data:{
                id:$('#operator_id').html(),
                cc:$('#country').val(),
                amount:newValue
            },
            dataType:'json',
            success: function (fxRate) {
                $('#sent_amount').removeClass('d-none');
                $('#btn-sent-topup').removeClass('d-none');
                $('#sent_amount').html(fxRate.toFixed(2) +' '+ $('#destination_currency').html());
            }
        })
    }
    else{
        $('#btn-sent-topup').addClass('d-none');
        $('#sent_amount').addClass('d-none');
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

    if(clientID === 0){
        localStorage.setItem('local','checkout')
        return showLoginModal(event);
    }

    localStorage.setItem('local','')

    let data = {
        total:$("#amount").val(),
        phone_number:$("#phone_number").val(),
        sent_amount:$("#sent_amount").html().split(' ')[0],
        destination_currency:$('#destination_currency').html(),
        sender_currency:$('#sender_currency').html(),
        country_code: $('#country').val(),
        operator_id: $('#operator_id').html(),
        fixed: $('#fixed').html()
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
            endRequest($credicardForm)
        }
    });
}

function endRequest(form) {

    $.ajax({
        type: 'post',
        url: '/checkout',
        data:$(form).serializeArray(),
        dataType: 'json',
        success:function (response) {
            $('#myModal').modal('show')
            //notificationToast(response.message, 'success', '/');
        },
        error: function (response) {
            notificationToast(response.responseJSON.message, 'error', null);
        }
    });
}

function getFixedValues(fixedValue){

   let res = $.ajax({
       type: 'post',
       url: '/operator/fxRate',
       data:{
           id:$('#operator_id').html(),
           cc:$('#country').val(),
           amount:fixedValue,
           type:'fixed'
       },
       async:false
   });
   return res.responseText;
}

function handleFixedValue(event, fixedValue, received) {
    event.preventDefault();
    $('#card-values').addClass('d-none')
    $('#sending-tr').removeClass('d-none')
    $('#delivered-tr').removeClass('d-none')
    $('#taxe-tr').removeClass('d-none')
    $('#pay-tr').removeClass('d-none')
    $('#fixed').html(1);
    let destCurrency = $('#destination_currency').html();
    let sendCurrency = $('#sender_currency').html();

    $('#sendingValue').html(fixedValue+' '+sendCurrency);
    $('#deliveredValue').html(received+' '+destCurrency);

   // $('#receive_amount').val(fixedValue+' '+destCurrency)
    $('#fixedSendValue').html(fixedValue)
    $('#sent_amount').html(fixedValue+' '+destCurrency)
   let tax = parseFloat(fixedValue*0.15).toFixed(2);
    $('#taxe').html(tax+' '+sendCurrency)
    let valTotal = parseFloat(fixedValue + Number(tax)).toFixed(2)
    $('#total').html(valTotal+' '+sendCurrency)
    $('#amount').val(valTotal)
    $('#btn-sent-topup').removeClass('d-none');
}

function createTopupElement(operator) {
    $('#home-page').addClass('d-none')
    let phone = $('#phone_number').val();
    let countryName = $('#country').find('option:selected').attr("name");
    let ddi = $('#country').find('option:selected').attr("data-ddi");
    let countryFlag = $('#country').find('option:selected').attr("data-country-flag");
    operator.phone = phone;
    operator.countryName = countryName;
    operator.ddi = ddi;

    $('#topup-data').removeClass('d-none');
    $('#operator_id').html(operator.rid);
    $('#detail_country_name').html(operator.countryName);
    $('#detail_country_flag').prop('src',countryFlag);
    $('#operator_name').html(operator.name);
    $('#operator_image').prop('src',operator.logo_urls[0]);
    $('#operator_dest_number').html(operator.ddi + '' + operator.phone);
    $('#sender_currency').html(operator.sender_currency_code);
    $('#destination_currency').html(operator.destination_currency_code);

    $('#sending-tr').addClass('d-none')
    $('#delivered-tr').addClass('d-none')
    $('#taxe-tr').addClass('d-none')
    $('#pay-tr').addClass('d-none')

    if (operator.denomination_type === 'FIXED') {
        $('#amount_field').addClass('d-none');
        $('#btn-sent-topup').addClass('d-none');

        let card = ``;
        for (let i = 0; i < operator.fixed_amounts.length; i++) {
            let deliveredAmount = getFixedValues(operator.fixed_amounts[i]);
            deliveredAmount = Number(deliveredAmount).toFixed(2);
            let fixedValue = Number(operator.fixed_amounts[i]).toFixed(2);

            card +=`
                <a
                    id="cardValue"
                    onclick="handleFixedValue(event,${fixedValue},${deliveredAmount})"
                >
                    <div class="card card-value-item">
                        <div class="card-header text-center">
                             <h2 id="sendFixedValue">${fixedValue+' '+operator.sender_currency_code}</h2>
                         </div>
                         <div class="card-body">
                            <h3 class="card-title text-center" id="deliveredAmount">${deliveredAmount +' '+ $('#destination_currency').html()}</h3>
                        </div>
                    </div>
                </a><br><br>`;
        }
        $('#card-values').html(card);
    }
}

function showAllCountry() {
    alert('Teste')
}

function getDataOfCountry(){
    let countryField = $('#country');
    $('#country_flag').prop('src',countryField.find('option:selected').attr("data-country-flag"));
    $('#country-code').val(countryField.find('option:selected').attr("data-ddi"));
}

function getOperatorFlag(){
    $('#operator_flag_div').removeClass('d-none');
    $('#operator_flag').prop('src',$('#operator').find('option:selected').attr("data-operator-flag"));
}

function criarPDF() {
    var minhaTabela = document.getElementById('table').innerHTML;
    var style = "<style>";
    style = style + "table {width: 100%;font: 20px Calibri;}";
    style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
    style = style + "padding: 2px 3px;text-align: center;}";
    style = style + "</style>";
    // CRIA UM OBJETO WINDOW
    var win = window.open('', '', 'height=700,width=700');
    win.document.write('<html><head>');
    win.document.write('<title>Empregados</title>');   // <title> CABEÇALHO DO PDF.
    win.document.write(style);                                     // INCLUI UM ESTILO NA TAB HEAD
    win.document.write('</head>');
    win.document.write('<body>');
    win.document.write(minhaTabela);                          // O CONTEUDO DA TABELA DENTRO DA TAG BODY
    win.document.write('</body></html>');
    win.document.close(); 	                                         // FECHA A JANELA
    win.print();                                                            // IMPRIME O CONTEUDO
}

function setLanguages(lang){
    new google.translate.TranslateElement({
        pageLanguage: 'fr',
        includedLanguages: 'et',
        autoDisplay: false
    }, 'google_translate_element');
    let a = document.querySelector("#google_translate_element select");
    a.selectedIndex=1;
    a.dispatchEvent(new Event('change'));
}

$(window).on('load',function () {
    getDataOfCountry();
})



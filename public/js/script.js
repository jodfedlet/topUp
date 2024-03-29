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


function getAllOperatorsByCountryId(countryId) {
   let res = $.ajax({
        type: 'GET',
        url: '/countries/'+countryId+'/operators',
        async: false
    })
    return JSON.parse(res.responseText);
}

function getByCountryAndPhone(event,where) {
    event.preventDefault();
    let phone = $('#phone_number').val();
    let country = $('#country').val();
    let countryId = $('#country').find('option:selected').attr("data-countryId");

    $.ajax({
        type: 'GET',
        url: '/countries/'+country+'/operators/detect/'+phone,
        success: function (operator) {
            if(!operator){
                let operators = getAllOperatorsByCountryId(countryId);
                let options = '<option value="">Select the operator</option>';
                for (let i = 0; i < operators.length; i++) {
                    let log = JSON.parse(operators[i].logo_urls);
                    options += '<option value="' + operators[i].id + '" data-operator-flag="'+log[0]+'">' + operators[i].name + '</option>';
                }

                if(where === 'adm'){
                    $('#select-operators-adm').modal('show');
                    $('#operator-adm').html(options);
                }
                else{
                    $('#select-operators').modal('show');
                    $('#operator').html(options);
                }
            }
            else{
                createTopupElement(operator, where);
            }
        }
    })
}

function submitOperator(event,where){
    event.preventDefault();
    let operatorId = (where === 'adm')?$('#operator-adm').val():$('#operator').val()

    if(typeof operatorId !== 'undefined' && operatorId !== ''){
        $.ajax({
            type: 'GET',
            url: '/operator/'+operatorId,
            beforeSend:showLoader(),
            success: function (operator) {
                if (where === 'adm'){
                    $('#select-operators-adm').modal('hide');
                }
                else{
                    $('#select-operators').modal('hide');
                }
                createTopupElement(operator,where);
            }
        })
    }
}

$('#valeur').on('input',function(){

    //let valeur = $('#valeur').val();

    $('#btn-sent-next').addClass('d-none');
   // $('#btn-sent-next').prop('disabled', true);
    $('#sent_amount').addClass('d-none');
})

function updateValue(where){
    /*$('#btn-sent-next').addClass('d-none');
    $('#sent_amount').addClass('d-none');*/

    let operatorId = (where === 'adm')?$('#operator_id').val():$('#operator_id').html()

    let newValue = $('#valeur').val();

    if(newValue > 0) {
        $.ajax({
            type: 'post',
            url: '/operator/fxRate',
            data:{
                id:operatorId,
                cc:$('#country').val(),
                amount:newValue
            },
            dataType:'json',
            success: function (fxRate) {
                $('#btn-sent-topup').prop("disabled",false);
                handleRandomValues(newValue,fxRate,where)
            }
        })
    }
    else{
        if (where !== 'adm') {
            $('#btn-sent-next').addClass('d-none');
            $('#btn-sent-next').prop('disabled', true);
            $('#sent_amount').addClass('d-none');
            $('#sending-tr').addClass('d-none')
            $('#delivered-tr').addClass('d-none')
            $('#taxe-tr').addClass('d-none')
            $('#pay-tr').addClass('d-none')
        }
        else {
            $('#receive_amount').addClass('d-none')
            $('#btn-sent-topup').addClass('d-none');
        }
    }
}

function hideOption(){
    $('#receive_amount').addClass('d-none')
    $('#btn-sent-topup').prop("disabled",true);
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
        total:$("#total").html().split(' ')[0],
        phone_number:$("#phoneNumber").val(),
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
            $('#success-message').html(response.message)
            $('#myModal').modal('show')
            //notificationToast(response.message, 'success', '/');
        },
        error: function (response) {
            notificationToast(response.responseJSON.message, 'error', null);
        }
    });
}

function getFixedValues(where){
    let fixedValue = $('#fixedValue-adm').val()
    let operatorId = (where === 'adm')?$('#operator_id').val():$('#operator_id').html()
    $('#taxes').addClass('d-none')
    $('#receive_amount').addClass('d-none')
    $('#btn-sent-topup').addClass('d-none');
    $('#btn-sent-topup').prop('disabled',true);

       $.ajax({
           type: 'post',
           url: '/operator/fxRate',
           data:{
               id:operatorId,
               cc:$('#country').val(),
               amount:fixedValue,
               type:'fixed'
           },
           success:function (response) {
               let taxes = Number(response[0].taxes).toFixed(2)
               let total = Number(fixedValue) + Number(taxes)
               $('#valeur').val(total)
               $('#sent_amount').val(Number(fixedValue))

               $('#receive_amount').removeClass('d-none')
               $('#taxes').removeClass('d-none')
               $('#receive_amount').html(Number(response[0].fxRate).toFixed(2)+' '+$('#destinationCurrency').val())
               $('#taxes').html('Pour les opérateurs de valeurs fixes, l\'acheteur doit payer des frais de: '+taxes+' '+$('#sender_currency').val())
               $('#taxes').css('color','red')
               $('#btn-sent-topup').removeClass('d-none');
               $('#btn-sent-topup').html('Accepter et Envoyer '+total.toFixed(2)+' '+$('#sender_currency').val());
               $('#btn-sent-topup').prop('disabled',false);
           }
       });
}

function handleRandomValues(fixedValue, received, where) {
    if(where === 'adm'){
        $('#receive_amount').removeClass('d-none')
        $('#receive_amount').html(Number(received).toFixed(2)+' '+$('#destinationCurrency').val())
        $("#sent_amount").val(fixedValue)
        setTimeout(function () {
            $('#btn-sent-topup').removeClass('d-none');
        }, 2)
    }
    else {

        $('#fixed-value').addClass('d-none')
        $('#sending-tr').removeClass('d-none')
        $('#delivered-tr').removeClass('d-none')
        $('#taxe-tr').removeClass('d-none')
        $('#pay-tr').removeClass('d-none')
        $('#fixed').html(0);
        let destCurrency = $('#destination_currency').html();
        let sendCurrency = $('#sender_currency').html();

        $('#sendingValue').html(fixedValue + ' ' + sendCurrency);
        $('#deliveredValue').html(Number(received).toFixed(2) + ' ' + destCurrency);

        // $('#receive_amount').val(fixedValue+' '+destCurrency)
        $('#fixedSendValue').html(Number(fixedValue).toFixed(2))
        $('#sent_amount').html(Number(fixedValue).toFixed(2) + ' ' + destCurrency)
        let tax = parseFloat(0).toFixed(2);
        $('#taxe').html(tax + ' ' + sendCurrency)
        let valTotal = parseFloat(fixedValue).toFixed(2)

        $('#total').html(valTotal + ' ' + sendCurrency)
        setTimeout(function () {
            $('#btn-sent-next').removeClass('d-none');
        }, 2)
    }
}

function handleFixedValue(event, fixedValue, received) {
    event.preventDefault();
    $('#fixed-value').addClass('d-none')
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
    setTimeout(function () {
        $('#btn-sent-next').removeClass('d-none');
    },2)

}

function createTopupElement(operator, where) {

    operator.phone = $('#phone_number').val();
    operator.cc = $('#country').val();
    operator.countryName = $('#country').find('option:selected').attr("name");
    operator.ddi = $('#country').find('option:selected').attr("data-ddi");
    operator.countryFlag = $('#country').find('option:selected').attr("data-country-flag");

    if(where === 'adm'){
        $('#operator_id').val(operator.rid)
        //$('#countryCode').val(operator.countryName)
        $('#countryCode').val($('#country').val())
        $('#detail_country_name_adm').html(operator.countryName)
        $('#detail_country_flag_adm').prop('src',operator.countryFlag)
        $('#detail_operator_name_adm').html(operator.name)
        $('#detail_operator_flag_adm').prop('src',operator.logo_urls[0])
        $('#adm_phone_resume').html(operator.ddi+''+operator.phone)

        $('#sender_currency').val(operator.sender_currency_code)
        $('#destinationCurrency').val(operator.destination_currency_code)
        $('#adm-search-country').addClass('d-none')
        $("#adm-show-data").removeClass('d-none')

        if (operator.denomination_type === 'FIXED'){
            $('#amountField').addClass('d-none')
            $('#fixedValue-adm').removeClass('d-none')
            $('#fixed').val(1)

            let options = '<option value="">Select the amount</option>';
            for (let i = 0; i < operator.fixed_amounts.length; i++) {
                options += '<option value="' + operator.fixed_amounts[i] + '">' + operator.fixed_amounts[i] +' '+operator.sender_currency_code+ '</option>';
            }
            $('#fixedValue-adm').html(options)
        }
        else{
            $('#fixed').val(0)
        }
    }
    else {
        window.location.href = '/topup-data?data=' + window.btoa(JSON.stringify(operator));
    }

    /*
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
    $('#pay-tr').addClass('d-none')*/

    /*
    if (operator.denomination_type === 'FIXED') {
        $('#amount_field').addClass('d-none');
        $('#btn-sent-topup').addClass('d-none');

       /* let card = ``;
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
    }*/
}

function showAllCountry() {
    alert('Teste')
}

function getDataOfCountry(){
    let countryField = $('#country');
    $('#country_flag').prop('src',countryField.find('option:selected').attr("data-country-flag"));
    $('#country-code').val(countryField.find('option:selected').attr("data-ddi"));
}

function getOperatorFlag(where){
    if (where === 'adm'){
        console.log('Teste')
    }else {
        $('#operator_flag_div').removeClass('d-none');
        $('#operator_flag').prop('src', $('#operator').find('option:selected').attr("data-operator-flag"));
    }
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



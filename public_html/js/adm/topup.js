
/*function getByCountryAndPhone(event) {
    event.preventDefault();
    let phone = $('#phone_number').val();
    let country = $('#country').val();
    let countryId = $('#country').find('option:selected').attr("data-countryId");
    console.table(phone, country, countryId)
}*/

function sendTopupAdm(event){
    event.preventDefault();

    let data = {
        value_to_pay:$('#valeur').val(),
        fixed:$('#fixed').val(),
        sent_amount:$('#sent_amount').val(),
        country_code:$('#countryCode').val(),
        phone_number:$('#phone_number').val(),
        operator_id:$('#operator_id').val(),
    };

    $.ajax({
        type: 'post',
        url: '/adm/topup',
        data:data,
        success:function (response) {
            $('#receipt').removeClass('d-none')
            $('#adm-show-data').addClass('d-none')
            $('#topup-title').addClass('d-none')
            $('#operatorName').html(response.data.operatorName)
            $('#recipientPhone').html(response.data.recipientPhone)
            $('#rec_sent_amount').html(data.sent_amount+' '+$('#sender_currency').val())
            $('#deliveredAmount').html(Number(response.data.deliveredAmount).toFixed(2)+' '+$('#destinationCurrency').val())
            $('#rec_taxes').html(Number(response.data.taxes).toFixed(2)+' '+$('#sender_currency').val())
            $('#total_payer').html((Number(response.data.taxes).toFixed(2) + Number(data.sent_amount).toFixed(2))+' '+$('#sender_currency').val())
        },
        error:function (response) {
            notificationToast(response.responseJSON.message, 'error', null);
        }
    });
}

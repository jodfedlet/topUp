function logon(event){
    event.preventDefault();

    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    let error = document.getElementById("msg-error-login")

    if((email === "") || typeof email === 'undefined' || (password === "") || typeof password === 'undefined')
        showError(error, "Les données sont incorrectes");
    else
        hideError(error);

    if(countErrors > 0){
        countErrors = 0;
        return false;
    }else {

        let data = {
            email: email,
            password: password
        }

        $.post('/users', data, function (response) {
            console.table(response);
            return
            /*  if (data.success === true) {
                  notificationToast(3, data.message, 'success', '/adm/transaction');
              } else {
                  notificationToast(3, data.message, 'error', null);
              }*/
        });
    }
}

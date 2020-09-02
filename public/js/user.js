function logon(event){
    event.preventDefault();
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    let error = document.getElementById("msg-error-login")

    if((email === "") || typeof email === 'undefined' || (password === "") || typeof password === 'undefined')
        showError(error, "Tous les champs sont obligatoires");
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

        $.ajax({
            url:'/users/',
            type:'post',
            data:data,
            success:function(response){
               window.location.href = response.redirect
                hideError(error);
            },
            error:function (response) {
                showError(error, response.responseJSON.error);
            }
        });


    }
}

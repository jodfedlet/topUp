function logon(event,where){
    event.preventDefault();

    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    let error = document.getElementById("msg-error-login")
    if (where === 'adm'){
        email = document.getElementById('email-normal').value;
        password = document.getElementById('password-normal').value;
        error = document.getElementById("msg-error-login-normal")
    }

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
            url:'/login',
            type:'post',
            data:data,
            dataType:'json',
            success:function(response){
                if(localStorage.getItem('local') === 'checkout'){
                    getCheckout(event, response.userId)
                }else{
                    window.location.href = response.redirect
                }
                hideError(error);
            },
            error:function (response) {
                showError(error, response.responseJSON.error);
            }
        });
    }
}

function create(event){
    event.preventDefault();

    let name = document.getElementById('name-create').value;
    let error = document.getElementById("msg-error-name-create")

    if(name === "" || typeof name === 'undefined')
        showError(error, "Le nom est obligatoire");
    else
        hideError(error);

    let email = document.getElementById('email-create').value;
    error = document.getElementById("msg-error-email-create")

    if(email === "" || typeof email === 'undefined')
        showError(error, "L'addresse email est obligatoire");
    else if (email.indexOf("@") === -1)
        showError(error, "Entrez une addresse email valide");
    else
        hideError(error);

    let password = document.getElementById('password-create').value;
    error = document.getElementById("msg-error-password-create")

    if(password === "" || typeof password === 'undefined')
        showError(error, "Le password est obligatoire");
    else if(password.length < 6)
        showError(error, "Entrez un mot de passe supérieur ou égal à 6 caractères.");
    else
        hideError(error);

    if(countErrors > 0){
        countErrors = 0;
        return false;
    }else {
        let data = {
            name: name,
            email: email,
            password: password
        }

        $.ajax({
            url:'/users/create',
            type:'post',
            data:data,
            success:function(response){
                if(localStorage.getItem('local') === 'checkout'){
                    return showLoginModal(event);
                }else{
                    window.location.href = response.redirect
                }
                hideError(error);
            },
            error:function (response) {
                error = document.getElementById("msg-create")
                showError(error, response.responseJSON.error);
            }
        });
    }

}

function getEmailToResetPassword(event) {
    event.preventDefault();

    let email = document.getElementById('email-forgot').value;
    let error = document.getElementById("msg-error-forgot")
    if((email === "") || typeof email === 'undefined')
        showError(error, "Veuillez entrez l'email")
    else
        hideError(error);

    if(countErrors > 0){
        countErrors = 0;
        return false;
    }else {

        let data = {
            email: email
        }

        $.ajax({
            url:'/resetEmail',
            type:'post',
            data:data,
            dataType:'json',
            success:function(response){
                notificationToast(response.message,'success',null);
                hideError(error);
            },
            error:function (response) {
                showError(error, response.responseJSON.error);
            }
        });
    }

}

function confirmResetPassword(event){
    event.preventDefault();
    let forgot = document.getElementById('forgot').value
    let password = document.getElementById('password').value;
    let error = document.getElementById("msg-reset");

    let confirm = document.getElementById('password-confirm').value;

    if(password.length < 6)
        showError(error, "Le contenu du mot de passe doit être supérieur à 6 caractères!");
    else if(forgot === '' || typeof forgot === 'undefined' || forgot === null)
        showError(error, "Ce link est invalide");
    else if(confirm !== password)
        showError(error, "Les mots de passe doivent-être identiques");
    else
        hideError(error);

    if(countErrors > 0){
        countErrors = 0;
        return false;
    }else {

        let data = {
            forgot: forgot,
            password: password
        }

        $.ajax({
            url:'/reset/confirm',
            type:'post',
            data:data,
            success:function(response){
                notificationToast(response.message, 'success', '/login');
            },
            error:function (response) {
                notificationToast(response.responseJSON.error, 'error', null);
            }
        });
    }
}


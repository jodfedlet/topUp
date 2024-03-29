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

        $('button[type="submit"] i').toggleClass('d-none')
        $.ajax({
            url:'/login',
            type:'post',
            data:data,
            dataType:'json',
            success:function(response){
                $('button[type="submit"] i').toggleClass('d-none')
                if(localStorage.getItem('local') === 'checkout'){
                    getCheckout(event, response.userId)
                }else{
                    window.location.href = response.redirect
                }
                hideError(error);
            },
            error:function (response) {
                $('button[type="submit"] i').toggleClass('d-none')
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
        $('button[type="submit"] i').toggleClass('d-none')
        $.ajax({
            url:'/users/create',
            type:'post',
            data:data,
            success:function(response){
                $('button[type="submit"] i').toggleClass('d-none')
                if(localStorage.getItem('local') === 'checkout'){
                    return showLoginModal(event);
                }else{
                    window.location.href = response.redirect
                }
                hideError(error);
            },
            error:function (response) {
                $('button[type="submit"] i').toggleClass('d-none')
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

        $('button[type="submit"] i').toggleClass('d-none')
        $.ajax({
            url:'/resetEmail',
            type:'post',
            data:data,
            dataType:'json',
            success:function(response){
                $('button[type="submit"] i').toggleClass('d-none')
                notificationToast(response.message,'success',null);
                hideError(error);
            },
            error:function (response) {
                $('button[type="submit"] i').toggleClass('d-none')
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
        showError(error, "Le mot de passe doit être supérieur ou égal à 6 caractères!");
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

function resellerBalance(idReseller) {

    if (idReseller > 0){
        $.ajax({
            url:'/get-reseller-data',
            type:'post',
            data:{
                id:idReseller
            },
            dataType:'json',
            success:function(response){
                $("#resellerId").val(response.data.id)
                $("#reseller-name").html(response.data.name)
                $("#current-balance").html(response.data.balance)
                $("#btn-add-balance").prop('disabled',true)
                $("#btn-remove-balance").prop('disabled',true)
                $("#balance").modal('show')
            },
        });
    }
}

function buttonOption(field) {
    let value = field.value;
    if (value > 0){
        $("#btn-add-balance").prop('disabled',false)
        $("#btn-remove-balance").prop('disabled',false)
    }
    else{
        $("#btn-add-balance").prop('disabled',true)
        $("#btn-remove-balance").prop('disabled',true)
    }
}

function addBalance(e){
    e.preventDefault();
    let balanceValue = $("#balanceAmount").val();
    let idReseller = $("#resellerId").val();

    if (balanceValue > 0 && idReseller > 0){
        $.ajax({
            url:'/reseller-balance',
            type:'post',
            data:{
                id:idReseller,
                amount:balanceValue,
                operation:'add'
            },
            dataType:'json',
            success:function(response){
                notificationToast(response.message,'success',response.redirect);
            },
            error:function (response) {
                notificationToast(response.responseJSON.error,'error',null);
            }
        });
    }
}

function removeBalance(e){
    e.preventDefault();
    let balanceValue = $("#balanceAmount").val();
    let idReseller = $("#resellerId").val();

    if (balanceValue > 0 && idReseller > 0) {
        $.ajax({
            url: '/reseller-balance',
            type: 'post',
            data: {
                id: idReseller,
                amount: balanceValue,
            },
            dataType: 'json',
            success: function (response) {
                notificationToast(response.message, 'success', response.redirect);
            },
            error: function (response) {
                notificationToast(response.responseJSON.error, 'error', null);
            }
        });
    }
}

@include('layouts._site._header')

<section class="login-block">
    <div class="container ">
        <div class="row">
            <div class="col-md-4"></div>

            <div class="col-md-5 login-sec">
                <h2 class="text-center">Récupération du mot de passe</h2>
                    <span class="msg-error" id="msg-reset"></span>
                    <div class="form-group">
                        <input
                            type="password"
                            placeholder="Créer le mot de passe"
                            class="form-control"
                            id="password"
                            name="password"
                        />
                    </div>

                    <div class="form-group">
                        <input
                            type="password"
                            placeholder="Confirmer le mot de passe"
                            class="form-control"
                            id="password-confirm"
                            name="password-confirm"
                        />
                    </div>
                    <input type="hidden" id="forgot" value="{{$forgot['forgot']}}">

                    <button
                        class="btn btn-success form-control form-btn"
                        type="submit"
                        onclick="confirmResetPassword(event)"
                    >
                        Récupérer
                    </button>
            </div>
        </div>
    </div>
</section>

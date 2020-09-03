@extends('layouts.site')

@section('title','Login')

@section('content')
    <div class="container login-form">
        <div class="login-form-content">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Connexion</h3>
                </div>

                <div class="card-body">
                    <form id="login-normal" onsubmit="logon(event,true)">
                        <div>
                            <span class="msg-error text-center" id="msg-error-login-normal"></span>
                        </div><br>
                        <div class="form-group">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter your username" required>
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="form-control btn btn-outline-success" id="login"  value="Log In">
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="card-action">
                        <p><a href=""onclick="showForgotModal(event)">Mot de passe oublié ?</a></p>
                        <p><a href=""onclick="showCreateModal(event)">Pas de compte ? Créez-en un</a></p>
                    </div>
                </div>
                </div>
        </div>
    </div>
@endsection

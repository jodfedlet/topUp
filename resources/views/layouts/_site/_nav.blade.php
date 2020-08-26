<nav class="navbar navbar-expand-md navbar-light bg-light">
    <a class="navbar-brand" href="/"><img src=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto active">
            <li class="dropdown" style="padding-right:1em">
               <a href="" class="dropdown-toggle" data-toggle="dropdown">Langues<span id="languages"></span></a>

                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="languages">
                    <li><a class="dropdown-item" href="">Français</a></li>
                    <li><a class="dropdown-item" href="">Créole</a></li>
                    <li><a class="dropdown-item" href="">Anglais</a></li>
                    <li><a class="dropdown-item" href="">Portuguais</a></li>
                    <li><a class="dropdown-item" href="">Espagnol</a></li>
                </ul>
            </li>
            <li style="padding-left:1em; padding-right:1em">
                <a href="" data-toggle="modal" data-target="#login">Login</a>
            </li>
        </ul>
    </div>
</nav>

<form class="modal fade" id="login">

    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <!-- header -->
            <div class="modal-header">
                <p>Log In &nbsp;<small>or</small> &nbsp; <a href="" data-toggle="modal" data-target="#create"><em>Create an account</em></a></p>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div><br>

            <!-- body -->
            <div class="modal-body">

                <div class="form-group">
                    <input type="text" class="form-control" id="email" placeholder="Enter your username" required>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                </div>
                <div class="form-group">
                    <input type="submit" class="form-control btn btn-outline-success" id="btn-login" value="Log In">
                </div>

            </div>

            <!-- footer -->
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-6 ">

                        <p id="forget-password">Forget your <a href="" onclick="showForgotModal(event)"><em>password?</em></a></p>

                    </div>

                    <div class="col-sm-6">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<form class="modal fade" id="create">
    <fieldset>
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <!-- header -->
                <div class="modal-header head">
                    <p class="text-center"><em> Create my account</em></p>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div><br>

                <!-- body -->
                <div class="modal-body">

                    <div class="form-group">
                        <label for="name">Complete Name:</label>
                        <input type="text" class="form-control" id="name" required placeholder="Your complete name">
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" required placeholder="Your email">
                    </div>

                    <div class="form-group">
                        <label for="pswd">Password:</label>
                        <input type="password" class="form-control" id="password" required placeholder="Your password">
                    </div>

                    <div class="form-group">
                        <input type="submit" class="form-control btn btn-outline-success" id="btn-create" value="Create">
                    </div>


                </div>
                <!-- footer -->
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-6 ">

                            <p id="has-account">Have you already had an <a href="" data-toggle="modal" data-dismiss="modal"><em>account?</em></a></p>

                        </div>

                        <div class="col-sm-6">
                            <button type="button" class="btn btn-danger"> Cancel</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </fieldset>
</form>

<form class="modal fade" id="forgot">
    <fieldset>
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <!-- header -->
                <div class="modal-header head">
                    <p class="text-center"><em> Forgot password</em></p>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div><br>

                <!-- body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="form-control btn btn-outline-success" id="btn-create" value="Send email">
                    </div>
                </div>
                <!-- footer -->
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-danger can">Cancel</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </fieldset>
</form>

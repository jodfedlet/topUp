
<header >
  <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <a class="navbar-brand" href="/">Top Up</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            @if(\Illuminate\Support\Facades\Auth::guest())
            <li style="padding-right:1em">
                <a href="#" data-toggle="modal" data-target="#login">Login</a>
            </li>
            @else
                <li class="dropdown" style="padding-right:1em">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown">{{\Illuminate\Support\Facades\Auth::user()->name}}<span id="languages"></span></a>

                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="languages">
                        <li><a class="dropdown-item" href="">Settings</a></li>
                        <li><a class="dropdown-item" href="/logout">Log Out</a></li>
                    </ul>
                </li>
            @endif
        <li class="dropdown" style="padding-right:1em">
            <a href="" class="dropdown-toggle" data-toggle="dropdown">Langues<span id="languages"></span></a>

            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="languages">
                <li><a class="dropdown-item" href="">Français</a></li>
                <li><a class="dropdown-item" href="">Kreyòl</a></li>
                <li><a class="dropdown-item" href="">English</a></li>
                <li><a class="dropdown-item" href="">Português</a></li>
                <li><a class="dropdown-item" href="">Español</a></li>
            </ul>
        </li>
        </ul>
    </div>
  </nav>
</header>

<form class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
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

                <form id="login-form">
                    <div>
                    <span class="msg-error text-center" id="msg-error-login"></span>
                    </div><br>
                    <div class="form-group">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter your username" required>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="form-control btn btn-outline-success" id="btn-login" onclick="return logon(event)" value="Log In">
                    </div>
                </form>

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

<nav class="navbar navbar-expand-md navbar-dark  bg-dark">
    <button class="navbar-toggler navbar-toggler-left" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    </button>
    <a class="navbar-brand" href=""><img src="">Nuvann</a>
    <div class="float-left"> <a href="#" class="button-left"><span class="fa fa-fw fa-bars "></span></a></div>
    <div class="collapse navbar-collapse flex-row-reverse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                @if (Auth::guest())
                    <a class="nav-link" href="">Home</a>
                @else
                    <a class="dropdown-item" href="">LogOut</a>
                @endif
            </li>
        </ul>
    </div>
</nav>

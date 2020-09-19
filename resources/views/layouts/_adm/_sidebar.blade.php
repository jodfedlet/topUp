
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="/adm">
        <img src="/../img/logo.png/" width="80" height="30" class="d-inline-block align-top" alt="">
        <span class="menu-collapsed">
      <a href="#top" data-toggle="sidebar-colapse" class="align-items-center">
        <div class="d-flex w-100 justify-content-start align-items-center">
          <span id="collapse-icon" class="fa fa-2x mr-3"></span>
          <span id="collapse-text" class="menu-collapsed"></span>
        </div>
      </a>
    </span>
    </a>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/adm/logout"><i class="fa fa-sign-out"></i> Deconnexion </a>
            </li>
        </ul>
    </div>
</nav>

<div class="page-wrapper chiller-theme toggled">
    <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
        <i class="fa fa-bars"></i>
    </a>
    <nav id="sidebar" class="sidebar-wrapper navbar-dark">
        <div class="sidebar-content">
            <div class="sidebar-brand text-center">
                <a href="/adm">Fast topup</a>
            </div>
            <div class="sidebar-header">
                    <div class="header-profile">
                        <img class="rounded-circle profile-image"
                             src="/../../img/topup.jpg"
                             alt="User picture"
                        >
                    </div><br>
                    <div class="user-info">
                        <h6 class="user-name">
                            <strong>Jod Fedlet PIERRE</strong>
                        </h6>
                        <span class="user-role"></span>
                        <span class="user-status"></span>
                    </div><br>
                <div class="user-balance">
                        <span class="user-name">
                            <strong>500</strong>
                        </span>
                    <span class="user-role"></span>
                    <span class="user-status"></span>
                </div>
            </div>

            <div class="sidebar-menu">
                <ul>
                    <li class="sidebar-dropdown">
                        <a href="#submenu1" data-toggle="collapse" aria-expanded="false">
                            <span class="fa fa-dashboard fa-fw mr-3"></span>
                            <span class="submenu-icon ml-auto"></span>
                            <span class="menu-collapsed text-white">Système </span>
                        </a>
                        <div id='submenu1' class="collapse sidebar-submenu text-center">
                            <a href="/adm/agent" class="list-group-item list-group-item-action bg-dark text-white">
                                <span class="menu-collapsed">Agent</span>
                            </a>
                        </div>
                    </li>
                    <br>
                    <li>
                        <a href="/adm/topup"class="text-white">
                            <span class="fas fa-mobile-alt fa-fw mr-3"></span>
                            <span class=" text-white">Topup</span>
                        </a>
                    </li>
                    <li>
                        <a href="/adm/transaction" class="text-white">
                            <span class="fa fa-database fa-fw mr-3"></span>
                            <span >Transactions</span>
                        </a>
                    </li>
                    <li>
                        <a href="/adm/contact" class="text-white">
                            <span class="fa fa-phone fa-fw mr-3"></span>
                            <span >Contact</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="text-white" id="reload-page">
                            <span class="fa fa-sync fa-fw mr-3"></span>
                            <span class="menu-collapsed ml-2">Actualiser</span>
                        </a>
                    </li>

                    <li>
                        <a href="/adm/logout" class="text-white" id="reload-page">
                            <span class="fa fa-power-off fa-fw mr-3"></span>
                            <span class="menu-collapsed ml-2">Deconnexion</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- sidebar-wrapper  -->
</div>

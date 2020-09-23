@php
    use App\System;
    use App\User;
    $user = json_decode(User::find(Auth::id()));
    if ($user->level == 1){
        $user->balance = System::getData()->getBalance();
    }
    else if($user->level == 3){
        $user->balance = $user->balance.' BRL';
    }
@endphp

<div class="page-wrapper chiller-theme toggled">
    <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
        <i class="fa fa-bars"></i>
    </a>
    <nav id="sidebar" class="sidebar-wrapper navbar-dark">
        <div class="sidebar-content">
            <div class="sidebar-brand text-center">
                <a href="/adm">Fast topup</a>
                <div id="close-sidebar">
                    <i class="fa fa-times"></i>
                </div>
            </div>
            <div class="sidebar-header">
                    <div class="header-profile">
                        <img class="rounded-circle profile-image"
                             src="/../../img/topup.jpg"
                             alt="User picture"
                        >
                    </div>
                    <div class="user-info">
                        <h6 class="user-name">
                            <strong>{{$user->name}}</strong>
                        </h6>
                        <span class="user-role"></span>
                        <span class="user-status"></span>
                    </div>
                <div class="user-balance">
                        <span class="user-name">
                            <strong>{{$user->balance}}</strong>
                        </span>
                    <span class="user-role"></span>
                    <span class="user-status"></span>
                </div>
            </div><br>

            <div class="sidebar-menu">
                <ul>
                    @if($user->level == 1)
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
                    @endif
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
                    @if($user->level == 1)
                    <li>
                        <a href="/adm/contact" class="text-white">
                            <span class="fa fa-phone fa-fw mr-3"></span>
                            <span >Contact</span>
                        </a>
                    </li>
                     @endif

                    <li>
                        <a href="#" class="text-white" id="reload-page">
                            <span class="fa fa-sync fa-fw mr-3"></span>
                            <span class="menu-collapsed ml-2">Actualiser</span>
                        </a>
                    </li>

                    <li>
                        <a href="/logout" class="text-white" id="reload-page">
                            <span class="fa fa-power-off fa-fw mr-3"></span>
                            <span class="menu-collapsed ml-2">Deconnexion</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

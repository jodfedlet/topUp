@include('layouts._site._header')

<body class="main">
    <div>
        @include('layouts._adm._sidebar')
    </div>
    <div class="dash-content">
        @yield('content')
    </div>
</body>

@include('layouts._site._footer_links')

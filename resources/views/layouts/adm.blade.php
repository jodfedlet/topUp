@include('layouts._site._header')

{{--<body class="main">
    <div>
        @include('layouts._adm._sidebar')
    </div>
    <div class="dash-content">
        @yield('content')
    </div>
</body>--}}

<div class="row">
    <div class="col-md-2">
        @include('layouts._adm._sidebar')
    </div>
    <div id="container-drag" class="col-md-10 mt-3">
        <div class="container-fluid adm-layout">
            @yield('content')
        </div>
    </div>
</div>
</body>

@include('layouts._site._footer_links')

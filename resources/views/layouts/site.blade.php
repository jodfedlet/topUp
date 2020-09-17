@include('layouts._site._header')

  <body>
    <header>
      @include('layouts._site._nav')
    </header>

    <main>
        @yield('content')
    </main>

@include('layouts._site._footer_links')


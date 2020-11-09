<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TeamSpeak Request Center</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link href="/css/styles.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

  </head>
  <body id="app-layout">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <a class="navbar-brand" href="#">TSRC</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarToggler">
        <ul class="navbar-nav bd-navbar-nav flex-row">
          <li class="nav-item">
            <a class="nav-link" href="{{action('ChannelController@index')}}">{{ trans('app.menu.requests') }}</a>
          </li>
          @if (Auth::user())
            @if (Auth::user()->isAdmin())
              <li class="nav-item">
                <a class="nav-link" href="{{route('admin.index')}}">{{ trans('app.menu.admin_panel') }}</a>
              </li>
            @endif
          @endif
        </ul>
        <ul class="navbar-nav ml-md-auto">
          @if (Auth::guest())
            <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">{{ trans('app.menu.login') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/register') }}">{{ trans('app.menu.register') }}</a></li>
          @else
            <li class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1"
                                                                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }}
              </button>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a class="dropdown-item" href="{{ url('/user/' . Auth::user()->id . '/edit' ) }}">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{ trans('app.menu.edit') }}</a>
                </li>
                <li><a class="dropdown-item" href="{{ url('/logout') }}" onclick="event.preventDefault();
                                                                          document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out" aria-hidden="true"></i> {{ trans('app.menu.logout') }}</a>
                  <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                  </form>
                </li>
              </ul>
            </li>
          @endif
        </ul>
      </div>
    </nav>

    <div class="container pt-4">

      @include('partials.flash')

      @yield('content')

    </div>

    <!-- JavaScripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="/js/scripts.js"></script>
  </body>
</html>

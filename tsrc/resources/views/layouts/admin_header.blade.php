<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ route('admin.index') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>TS</b>RC</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>TeamSpeak</b> Request Center</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <p>
                            {{ Auth::user()->name }}
                            <small>{{ trans('user.created_at') }}: {{ Auth::user()->created_at->formatLocalized('%d %b %Y') }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                            <a href="{{ route('admin.users.show', Auth::user()->id) }}" class="btn btn-default btn-flat">{{ trans('app.menu.profile') }}</a>
                            </div>
                            <div class="pull-right">
                                    <a class="btn btn-default btn-flat" href="{{ url('/logout') }}" onclick="event.preventDefault();
                                                                                             document.getElementById('logout-form').submit();">
                                            {{ trans('app.menu.logout') }}</a>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

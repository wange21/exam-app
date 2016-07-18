<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-navbar" aria-expanded="false">
                <span class="sr-only">@lang('navbar.toggle')</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">{{ config('config.brand') }}</a>
        </div>

        <div class="collapse navbar-collapse" id="top-navbar">
            <ul class="nav navbar-nav">
                <li{!! $active === 'exams' ? ' class="active"' : '' !!}><a href="/exams">@lang('navbar.exams')</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="glyphicon glyphicon-log-out"></i> @lang('misc.logout')</a></li>
                            </ul>
                        </li>
                @else
                    <li{!! $active === 'login' ? ' class="active"' : '' !!}><a href="{{ url('/login') }}">@lang('misc.login')</a></li>
                    <li{!! $active === 'register' ? ' class="active"' : '' !!}><a href="{{ url('/register') }}">@lang('misc.register')</a></li>
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

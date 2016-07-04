<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-navbar" aria-expanded="false">
                <span class="sr-only">@lang('navbar.toggle')</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">{{ $brand or 'Online Exam' }}</a>
        </div>

        <div class="collapse navbar-collapse" id="top-navbar">
            <ul class="nav navbar-nav">
                <li @if ($active === 'exams') class="active" @endif><a href="/exams">@lang('navbar.exams')</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

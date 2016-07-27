<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]> <!--><html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta name="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="description" content="A web application for online programing languages exam">
        <meta name="author" content="Herobs <herobs@herobs.cn>">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="/assets/js/html5shiv.js"></script>
            <script src="/assets/js/respond.js"></script>
            <script src="/assets/js/es5-shim.js"></script>
            <script src="//cdn.bootcss.com/mathjax/2.5.3/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
            <script type="text/x-mathjax-config">
                MathJax.Hub.Config({
                    tex2jax: { inlineMath: [['$', '$']] },
                    messageStyle: "none"
                });
            </script>
        <![endif]-->
        <link rel="stylesheet" href="{{ asset('assets/themes/' . config('config.theme') . '/bundle.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/katex.min.css') }}">
        <title>@yield('title')</title>
    </head>
    <body>
        <div class="page-drawer">
            <div class="page-drawer__info">
                <i class="glyphicon glyphicon-user"></i> {{ $auth->student->name }}({{ $auth->student->student }})
                <div class="page-drawer__logout">
                    <a href="{{ '/exam/'.$auth->exam->id.'/logout' }}">退出登录</a>
                </div>
            </div>
            <ul class="page-drawer__nav nav">
                <li{!! pif($active === 'index', ' class="active"') !!}>
                    <a href="{{ '/exam/'.$auth->exam->id }}"><i class="glyphicon glyphicon-info-sign"></i> 考试信息</a>
                </li>
                @if (!$auth->pending)
                    @include('exam.drawer', ['item' => 'true-false', 'icon' => 'ok'])
                    @include('exam.drawer', ['item' => 'multi-choice', 'icon' => 'list'])
                    @include('exam.drawer', ['item' => 'blank-fill', 'icon' => 'tasks'])
                    @include('exam.drawer', ['item' => 'short-answer', 'icon' => 'comment'])
                    @include('exam.drawer', ['item' => 'general', 'icon' => 'align-justify'])
                    @include('exam.drawer', ['item' => 'program', 'icon' => 'console'])
                @endif
                <li class="page-drawer__divider"></li>
                <li><a href="/exams"><i class="glyphicon glyphicon-th"></i> 考试列表</a></li>
            </ul>
        </div>
        <div class="page-wrapper">
            <div class="page-wrapper__mask"></div>
            <button type="button" class="navicon navicon--x" aria-expanded="false">
                <span class="sr-only">@lang('navbar.toggle')</span>
                <span class="navicon__lines"></span>
            </button>
            @yield('content')
        </div>
        @include('layout.footer')
        <script src="{{ asset('assets/js/bundle.js') }}"></script>
    </body>
</html>

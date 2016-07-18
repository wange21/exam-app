@extends('layout.app')

@section('title', trans('login.title'))

@section('content')
@include('layout.navbar', ['active' => 'login'])
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form class="form-horizontal login-form form-box" role="form" method="POST" action="{{ url('/login') }}">
                {!! csrf_field() !!}
                <legend>@lang('login.legend')</legend>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">@lang('login.email')</label>
                    <div class="col-md-8">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">@lang('login.password')</label>
                    <div class="col-md-8">
                        <input type="password" class="form-control" name="password">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember"> @lang('login.remember')
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="glyphicon glyphicon-log-in"></i> @lang('login.login')
                        </button>
                        <div>
                            <a class="btn btn-link" href="{{ url('/register') }}">@lang('login.register')</a>
                            <a class="btn btn-link pull-right" href="{{ url('/password/reset') }}">@lang('login.forgot')</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('layout.footer')
@endsection

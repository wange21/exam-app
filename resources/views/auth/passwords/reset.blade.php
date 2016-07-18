@extends('layout.app')

@section('title', trans('passwords.reset.title'))

@section('content')
@include('layout.navbar', ['active' => ''])
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form class="form-horizontal form-box" role="form" method="POST" action="{{ url('/password/reset') }}">
                <legend>@lang('passwords.email.legend')</legend>
                {!! csrf_field() !!}
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">@lang('passwords.reset.email')</label>

                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" value="{{ $email or old('email') }}">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">@lang('passwords.reset.password')</label>

                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">@lang('passwords.reset.pwdcfm')</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password_confirmation">

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="glyphicon glyphicon-refresh"></i> @lang('passwords.reset.reset')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

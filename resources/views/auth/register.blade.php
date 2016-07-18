@extends('layout.app')

@section('title', trans('register.title'))

@section('content')
@include('layout.navbar', ['active' => 'register'])
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form class="form-horizontal register-form form-box" role="form" method="POST" action="{{ url('/register') }}">
                {!! csrf_field() !!}
                <legend>@lang('register.legend')</legend>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">@lang('register.name') *</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">@lang('register.email') *</label>

                    <div class="col-md-8">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('student') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">@lang('register.student') *</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="student" value="{{ old('student') }}">

                        @if ($errors->has('student'))
                            <span class="help-block">
                                <strong>{{ $errors->first('student') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('major') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">@lang('register.major')</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="major" value="{{ old('major') }}">

                        @if ($errors->has('major'))
                            <span class="help-block">
                                <strong>{{ $errors->first('major') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">@lang('register.password') *</label>

                    <div class="col-md-8">
                        <input type="password" class="form-control" name="password">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">@lang('register.pwdcfm') *</label>

                    <div class="col-md-8">
                        <input type="password" class="form-control" name="password_confirmation">

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="submit" class="btn btn-primary btn-block">
                            @lang('register.register')
                        </button>
                    </div>
                </div>
            </form>
            <div class="alert alert-warning">
                @lang('register.info')
            </div>
        </div>
    </div>
</div>
@include('layout.footer')
@endsection

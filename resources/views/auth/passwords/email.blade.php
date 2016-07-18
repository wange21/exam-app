@extends('layout.app')

@section('title', trans('passwords.email.title'))

@section('content')
@include('layout.navbar', ['active' => ''])
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form class="form-horizontal form-box" role="form" method="POST" action="{{ url('/password/email') }}">
                <legend>@lang('passwords.email.legend')</legend>
                {!! csrf_field() !!}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-2 control-label">@lang('passwords.email.email')</label>

                    <div class="col-md-8">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="glyphicon glyphicon-envelope"></i> @lang('passwords.email.send')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('layout.footer')
@endsection

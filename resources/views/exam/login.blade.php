@extends('layout.app')

@section('title', trans('exam.login.title') . $exam->name)

@section('content')
@include('layout.navbar', ['active' => ''])
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-1 col-md-push-4">
            <form class="form-horizontal exam-login-form form-box" role="form" method="POST" action="{{ url()->current() }}">
                {!! csrf_field() !!}
                <legend>{{ $exam->name }}</legend>
                @if ($exam->type === config('constants.EXAM_IMPORT_LIMITED'))
                    <div class="form-group{{ $errors->has('student') ? ' has-error' : '' }}">
                        <label class="col-md-2 control-label">@lang('exam.login.stuid')</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="student" value="{{ old('student') }}">
                            @if ($errors->has('student'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('student') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

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
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="glyphicon glyphicon-log-in"></i> @lang('login.login')
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-3 col-md-offset-1 col-md-pull-7 exam-login-info">
            <h3>{{ $exam->name }}</h3>
            <div>
                {{ trans('exam.login.teacher') .  $teacher->name }}
            </div>
            <div class="exam-status">
                @if ($exam->start > \Carbon\Carbon::now())
                    <div class="exam-status-title">@lang('exam.login.pending')</div>
                    <div class="exam-status-countdown">
                        {{ App\Utils::secondsTo($exam->start->diffInSeconds(\Carbon\Carbon::now()), 'DHM') }}
                    </div>
                @elseif ($exam->start->addSeconds($exam->duration) < \Carbon\Carbon::now())
                    <div class="exam-status-title">@lang('exam.login.ended')</div>
                @else
                    <div class="exam-status-title">@lang('exam.login.running')</div>
                    <div class="exam-status-countdown">
                        {{ App\Utils::secondsTo($exam->start->addSeconds($exam->duration)->diffInSeconds(\Carbon\Carbon::now()), 'DHM') }}
                    </div>
                @endif
            </div>
            <div class="exam-hint">
                {{ $exam->type === config('constants.EXAM_IMPORT_LIMITED') ? trans('exam.login.hint.import') : trans('exam.login.hint.password') }}
            </div>
        </div>
    </div>
</div>
@include('layout.footer')
@endsection

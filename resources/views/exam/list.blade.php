@extends('layout.app')

@section('title', trans('exam.list.title'))

@section('content')
@include('layout.navbar', ['active' => 'exams'])
<div class="container">
    <div class="row">
        <div class="col-sm-8 btn-toolbar">
            <div class="btn-group">
                <a class="btn {{ $type === 'all' ? 'btn-primary' : 'btn-default' }}" href="/exams">@lang('exam.list.all')@if ($type === 'all')({{$exams->total()}})@endif</a>
                <a class="btn {{ $type === 'running' ? 'btn-primary' : 'btn-default' }}" href="/exams/running">@lang('exam.list.running')@if ($type === 'running')({{$exams->total()}})@endif</a>
                <a class="btn {{ $type === 'pending' ? 'btn-primary' : 'btn-default' }}" href="/exams/pending">@lang('exam.list.pending')@if ($type === 'pending')({{$exams->total()}})@endif</a>
                <a class="btn {{ $type === 'ended' ? 'btn-primary' : 'btn-default' }}" href="/exams/ended">@lang('exam.list.ended')@if ($type === 'ended')({{$exams->total()}})@endif</a>
            </div>
            <!-- not implement now
            <div class="btn-group">
                <button class="btn btn-primary" type="button" class="exam-list-toggle-view" id="exam-list-toggle-list">
                    <i class="glyphicon glyphicon-th"></i>
                </button>
                <button class="btn btn-default" type="button" class="exam-list-toggle-view" id="exam-list-toggle-block">
                    <i class="glyphicon glyphicon-list"></i>
                </button>
            </div>
            -->
        </div>
        <div class="vehicle-divider visible-xs"></div>
        <div class="col-sm-4 text-right">
            <form class="form-inline" action="{{ url()->current() }}" method="GET">
                <div class="form-group">
                    <label class="sr-only" for="keywords">@lang('misc.search')</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="keywords" name="keywords" value="{{ $keywords }}" placeholder="@lang('misc.keywords')">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="exams list-group">
        @foreach($exams as $exam)
            <a class="list-group-item col-xs-12 col-sm-6 col-md-4 exam-item" href="/exams/{{ $exam->id }}">
                <div class="exam-header">
                    <span class="h3">{{ $exam->name }}</span>
                    @if ($exam->start > \Carbon\Carbon::now())
                        <span class="label label-info">Pending</span>
                    @elseif ($exam->start->addSeconds($exam->duration) < \Carbon\Carbon::now())
                        <span class="label label-warning">Ended</span>
                    @else
                        <span class="label label-success">Runing</span>
                    @endif
                </div>
                <div >
                    {{ trans('exam.list.start') . $exam->start }}
                </div>
                <div>
                    @lang('exam.list.duration'){{ App\Utils::secondsTo($exam->duration) }}
                </div>
                <div>
                    {{ trans('exam.list.teacher') .  $exam->teacher }}
                </div>
            </a>
        @endforeach
    </div>
    {{ $exams->links() }}
</div>
@include('layout.footer')
@endsection

@extends('layout.master')

@section('title', trans('exam.list.title'))

@section('content')
@include('layout.navbar', ['active' => 'exams'])
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <a class="btn {{ $type === 'all' ? 'btn-primary' : 'btn-default' }}" href="/exams">@lang('exam.list.all')</a>
            <a class="btn {{ $type === 'running' ? 'btn-primary' : 'btn-default' }}" href="/exams/running">@lang('exam.list.running')</a>
            <a class="btn {{ $type === 'pending' ? 'btn-primary' : 'btn-default' }}" href="/exams/pending">@lang('exam.list.pending')</a>
            <a class="btn {{ $type === 'ended' ? 'btn-primary' : 'btn-default' }}" href="/exams/ended">@lang('exam.list.ended')</a>
        </div>
        <div class="vehicle-divider visible-xs"></div>
        <div class="col-sm-6 text-right">
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
            <a class="list-group-item col-xs-12 col-sm-6 exams__item" href="/exams/{{ $exam->id }}">
                <div class="exams__header">
                    <span class="h3">{{ $exam->name }}</span>
                    @if ($exam->start > \Carbon\Carbon::now())
                        <span class="label label-success">Pending</span>
                    @elseif ($exam->start->addSeconds($exam->duration) < \Carbon\Carbon::now())
                        <span class="label label-warning">Ended</span>
                    @else
                        <span class="label label-info">Runing</span>
                    @endif
                </div>
                <div class="exams__time">
                    {{ trans('exam.list.start') . $exam->start }}
                </div>
                <div class="exams_duration">
                    @lang('exam.list.duration')
                    {{ intval($exam->duration / 3600) ? intval($exam->duration / 3600) . ' ' . trans('misc.hour') : '' }}
                    {{ intval($exam->duration / 60) ? intval($exam->duration / 60) . ' ' . trans('misc.minute') : '' }}
                </div>
                <div class="exams__teacher">
                    {{ trans('exam.list.teacher') .  $exam->teacher }}
                </div>
            </a>
        @endforeach
    </div>
    {{ $exams->links() }}
    <style>
        .exams__item {
            margin-top: 10px;
            width: 49%;
        }
        .exams__item:nth-child(2n) {
            margin-left: 2%;
        }
        .exams__header {
            margin-bottom: 5px;
        }
    </style>
</div>
@endsection

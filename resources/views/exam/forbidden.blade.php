@extends('layout.app')

@section('title', trans('exam.forbidden.title'))

@section('content')
@include('layout.navbar', ['active' => 'exams'])
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <h1>{{ $exam->name }}</h1>
        <h3>@lang('exam.forbidden.header')</h3>
        <p>@lang('exam.forbidden.reason')</p>
        <p>@lang('exam.forbidden.solution')</p>
        <p class="mt10">
            <a href="/" class="btn btn-primary">返回首页</a>
            <a href="/exams" class="btn btn-primary">考试列表</a>
        </p>
    </div>
</div>
@include('layout.footer')
@endsection

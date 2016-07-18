@extends('exam.master')

@section('title', $auth->exam->name)

@section('content')
<div class="exam-info">
    <div class="exam-info__header">
        <span class="h2">{{ $auth->exam->name }}</span>
        @if ($auth->pending)
            <span class="label label-info">准备中</span>
        @elseif ($auth->ended)
            <span class="label label-warning">已结束</span>
        @else
            <span class="label label-success">进行中</span>
        @endif
    </div>
    <div class="exam-info__time">
        考试时间：{{ $auth->exam->start }} - {{ $auth->exam->start->addSeconds($auth->exam->duration) }}
    </div>
    <div class="alert alert-info mt20">
        方框中的数字代表该题目的分数。蓝色背景表示你已经解答该题目，绿色背景表示你答对该题目，红色背景表示你答错该题目。
    </div>
    <div class="exam-info__block">
        @foreach($questionTypes as $type)
            @include('exam.info.questions', ['type' => $type])
        @endforeach
    </div>
</div>
@endsection

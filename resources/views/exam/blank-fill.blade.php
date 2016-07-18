@extends('exam.master')

@section('title', $auth->exam->name)

@section('content')
    <h2>填空题（{{ count($questions) . ' 题 / ' . array_reduce($questions->all(), function($sum, $n) { return $sum + $n->score; }, 0) . ' 分' }}）</h2>
    <form class="exam-questions exam-questions--blank-fill" method="POST" action="{{ url('exams/' . $auth->exam->id . '/blank-fill') }}">
        {!! csrf_field() !!}
        @foreach($questions as $i => $q)
            <?php $order = 0; if (isset($answers[$q->id])) $q->answer = $answers[$q->id]->answer; ?>
            <div class="exam-questions__question">
                <div class="exam-questions__content" data-order="{{ $i + 1 }}.">
                    （{{ $q->score }}  分）{!! $q->description !!}
                </div>
            </div>
        @endforeach
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="submit" value="保存">
        </div>
    </form>
@endsection

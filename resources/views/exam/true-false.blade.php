@extends('exam.master')

@section('title', $auth->exam->name)

@section('content')
    <h2>判断题（{{ count($questions) . ' 题 / ' . array_reduce($questions->all(), function($sum, $n) { return $sum + $n->score; }, 0) . ' 分' }}）</h2>
    <form class="exam-questions exam-questions--true-false" method="POST" action="{{ url('exams/' . $auth->exam->id . '/true-false') }}">
        {!! csrf_field() !!}
        @foreach($questions as $i => $q)
            <?php if (isset($answers[$q->id])) $q->answer = $answers[$q->id]->answer ?>
            <div class="exam-questions__question">
                <div class="exam-questions__content" data-order="{{ $i + 1 }}.">
                    （{{ $q->score . ' 分' . '）' . $q->description }}
                </div>
                <div class="exam-questions__answers clearfix">
                    <div class="exam-questions__answer col-xs-6 radio">
                        <label><input type="radio" name="{{ $q->id }}" value="true"{{ $q->answer === 'true' ? ' checked="checked"' : '' }}> 正确</label>
                    </div>
                    <div class="exam-questions__answer col-xs-6 radio">
                        <label><input type="radio" name="{{ $q->id }}" value="false"{{ $q->answer === 'false' ? ' checked="checked"' : '' }}> 错误</label>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="submit" value="保存">
        </div>
    </form>
@endsection

@if ($auth->questions[$type])
    <div class="exam-info__questions clearfix">
        <h3>{{ trans('exam.info.' . $type) . '（' . $auth->questions[$type] . ' 题 / ' . array_reduce($questions[camel_case($type)], function($sum, $n) { return $sum + $n->score; }, 0) . ' 分）' }}</h3>
        @foreach($questions[camel_case($type)] as $q)
            <a class="exam-info__question" href="{{ url('exams/' . $auth->exam->id . '/' . dash_case($type) . '#' . $q->id) }}">{{ $q->score }}</a>
        @endforeach
    </div>
@endif

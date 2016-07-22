@if ($auth->questions[$type])
    <div class="exam-info__questions clearfix">
        <h3>{{ trans('exam.info.'.$type).'（'.($auth->ended ? array_reduce($questions[camel_case($type)], function($sum, $n) { return $sum + $n->scoreGet; }, 0).' / ' : '').array_reduce($questions[camel_case($type)], function($sum, $n) { return $sum + $n->score; }, 0).' 分）' }}</h3>
        @foreach($questions[camel_case($type)] as $q)
            <a class="exam-info__question exam-info__question--{{ $q->status }}" href="{{ url('exams/'.$auth->exam->id.'/'.dash_case($type).($type === 'program' ? '/' : '#').$q->id) }}">{{ ($auth->ended && $q->scoreGet !== null ? $q->scoreGet.' / ' : '').$q->score }}</a>
        @endforeach
    </div>
@endif

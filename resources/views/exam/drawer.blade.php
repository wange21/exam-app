@if ($auth->questions[camel_case($item)])
    <li{!! $active === $item ? ' class="active"' : '' !!}>
        <a href="{{ url('exams/' . $auth->exam->id . '/' . $item) }}"><i class="glyphicon glyphicon-{{ $icon }}"></i> {{ trans('exam.info.' . camel_case($item)) }}</a>
    </li>
@endif

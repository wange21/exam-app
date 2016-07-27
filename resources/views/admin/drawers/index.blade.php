@section('nav')
<li{!! pif($active === 'index', ' class="active"') !!}><a href="/admin"><i class="glyphicon glyphicon-home"></i> 管理首页</a></li>
<li{!! pif($active === 'exams', ' class="active"') !!}><a href="/admin/exams"><i class="glyphicon glyphicon-list"></i> 我的考试</a></li>
<li{!! pif($active === 'questions', ' class="active"') !!}><a href="/admin/questions"><i class="glyphicon glyphicon-th-large"></i> 我的题库</a></li>
<li{!! pif($active === 'public', ' class="active"') !!}><a href="/admin/public"><i class="glyphicon glyphicon-th"></i> 公共题库</a></li>
@endsection

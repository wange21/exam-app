@extends('layout.master')

@section('title', '首页')

@section('content')
    @include('layout.navbar', ['active' => ''])
    <div class="container">
        <h1>Wellcome</h1><span class="glyphicon glyphicon-plus"></span>
    </div>
@endsection

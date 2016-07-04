@extends('layout.master')

@section('title', $exam->name)

@section('content')
@include('layout.navbar', ['active' => 'exams'])
    {{ $exam->name }}
@endsection

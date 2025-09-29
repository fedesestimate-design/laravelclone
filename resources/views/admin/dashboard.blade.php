@extends('layout.app')

@section('content')

@php
    echo  'Welcome' . Auth::user()->name;
    print_r(Auth::user());
@endphp

Admin Dashboard

@endsection
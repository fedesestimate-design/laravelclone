@extends('layout.app')
@section('content')
    <pre>
    @php
        echo  'Welcome ' . Auth::user()->name;
        print_r(Auth::user());
    @endphp
</pre>
@endsection
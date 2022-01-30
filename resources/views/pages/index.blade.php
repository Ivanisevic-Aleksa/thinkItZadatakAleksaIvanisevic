@extends('layouts.app')

@section('title')
    @include('components.nav')
@endsection()

@section('content')
    <div class="text-center" style="margin-top: 12vh;">
        <h1>Welcome back <strong>{{ Auth::user()->name }}</strong></h1>
    </div>
@endsection
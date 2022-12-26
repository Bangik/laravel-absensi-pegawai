@extends('layouts.home')

@section('title')
    Welcome - {{ $site_name }}
@endsection

@section('content')
    @if (Route::has('login'))
        <div class="text-center">
            @auth
                <a href="{{ url('/home') }}" class="btn btn-primary">Home</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
            @endauth
        </div>
    @endif
@endsection
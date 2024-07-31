@extends('layouts.app')

@section('content')
    @auth
        <h1>Benvenuto nella homepage dell admin</h1>
    @endauth
@endsection

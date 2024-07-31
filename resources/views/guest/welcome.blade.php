@extends('layouts.app')
@section('content')
    @guest
        <h1>Benvenuto nella home page del guest, collegati per vedere altro</h1>
    @endguest
@endsection


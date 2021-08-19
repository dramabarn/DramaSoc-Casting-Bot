@extends('dashboard.base')

@section('content')

    <div id="app">
        <view-users v-bind:people="{{ json_encode($people) }}">
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
@endsection

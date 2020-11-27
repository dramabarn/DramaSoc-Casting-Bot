@extends('dashboard.base')

@section('content')

    <div id="app">
        <view-productions v-bind:productions="{{ json_encode($productions ?? '')}}"></view-productions>
    </div>

    <script src="{{ asset('js/app.js') }}" defer></script>


@endsection

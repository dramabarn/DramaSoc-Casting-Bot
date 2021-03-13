@extends('dashboard.base')

@section('content')

    <div id="app">
        <view-production v-bind:productions="{{ json_encode($productions ?? '')}}"></view-production>
        <list-cast v-bind:productionChoices="{{ json_encode($productionChoices ?? '') }}"></list-cast>
    </div>

    <script src="{{ asset('js/app.js') }}" defer></script>

@endsection

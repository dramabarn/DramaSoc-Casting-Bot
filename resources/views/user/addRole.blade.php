@extends('dashboard.base')

@section('content')

    <div id="app">
        <enter-role></enter-role>
        <list-roles v-bind:roles="{{ json_encode($roles ?? '') }}"></list-roles>
    </div>

    <script src="{{ asset('js/app.js') }}" defer></script>

@endsection


@extends('dashboard.base')

@section('content')

    <div id="app">
        <enter-cast v-bind:ProductionRoles="{{$productionRoles ?? ""}}" v-bind:actors="{{$actors ?? ""}}"></enter-cast>
    </div>

        <script src="{{ asset('js/app.js') }}" defer></script>

@endsection


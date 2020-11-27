@extends('dashboard.base')

@section('content')

<div id="app">
    <list-cast v-bind:productionChoices="{{ json_encode($productionChoices) }}">
</div>
<script src="{{ asset('js/app.js') }}" defer></script>
@endsection
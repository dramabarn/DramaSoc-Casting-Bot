@extends('dashboard.base')

@section('content')

    <div id="app">
        <div class="col">
            <free-to-cast v-bind:castable="{{ json_encode($freeCast ?? '') }}"></free-to-cast>
            <list-deadlocks v-bind:deadlocks="{{ json_encode($deadlocks ?? '' ) }}"></list-deadlocks>
            <view-conflicts v-bind:productionconflicts="{{ json_encode($sharing ?? '' ) }}"></view-conflicts>
            <view-remaining-cast v-bind:productionchoices="{{ json_encode($productionchoices ?? '') }}"></view-remaining-cast>
            <view-casted v-bind:casted="{{ json_encode($casted ?? '') }}"></view-casted>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}" defer></script>


@endsection

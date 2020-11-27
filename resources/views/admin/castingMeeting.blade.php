@extends('dashboard.base')

@section('content')

    <div id="app">
        <div class="col">
{{--TODO for each production show cast --}}
            <view-remaining-cast v-bind:productionchoices="{{ json_encode($productionchoices ?? '')}}"></view-remaining-cast>
{{--TODO for each production show casted --}}
            <view-casted v-bind:casted="{{ json_encode($casted ?? '')}}"></view-casted>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}" defer></script>


@endsection

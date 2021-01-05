@extends('dashboard.base')

@section('content')
    <div id="app" class="col">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Welcome to the Super Secret Admin Menu!</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm">
                        <a href="{{route('castingMeeting')}}">
                            <div  class="card text-white bg-dark text-center">
                                <div class="card-body">
                                    <div>Casting Meeting</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm">
                        <a href="{{route('addShow')}}">
                            <div  class="card text-white bg-dark text-center">
                                <div class="card-body">
                                    <div>Add Shows</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm">
                        <a href="{{route('viewProductions')}}">
                            <div  class="card text-white bg-dark text-center">
                                <div class="card-body">
                                    <div>View Shows</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm">
                        <a href="{{route('viewPeople')}}">
                            <div  class="card text-white bg-dark text-center">
                                <div class="card-body">
                                    <div>People List</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <remove-all></remove-all>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
@endsection

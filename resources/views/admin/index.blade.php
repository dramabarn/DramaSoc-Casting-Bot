@extends('dashboard.base')

@section('content')
    <div id="announcement"><i class="bullhorn icon"></i>Welcome back, {{$username ?? ''}}</div>



    <div class="col-sm-6 col-lg-3">
        <a href="{{route('castingMeeting')}}">
            <div  class="card text-white bg-dark">
                <div class="card-body">
                    <div>Casting Meeting</div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-lg-3">
        <a href="{{route('addShow')}}">
            <div  class="card text-white bg-dark">
                <div class="card-body">
                    <div>Add Shows</div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-lg-3">
        <a href="{{route('viewProductions')}}">
            <div  class="card text-white bg-dark">
                <div class="card-body">
                    <div>View Shows</div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-lg-3">
        <a href="{{route('viewPeople')}}">
            <div  class="card text-white bg-dark">
                <div class="card-body">
                    <div>People List</div>
                </div>
            </div>
        </a>
    </div>


@endsection

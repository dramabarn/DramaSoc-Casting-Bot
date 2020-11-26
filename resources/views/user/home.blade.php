@extends('dashboard.base')

@section('content')
<div id="announcement"><i class="bullhorn icon"></i>Welcome back, {{$username ?? ''}}</div>



<div class="col-sm-6 col-lg-3">
    <a href="/cast/enter">
    <div  class="card text-white bg-primary">
        <div class="card-body">
            <div>Enter Casting Choice</div>
        </div>
    </div>
    </a>
</div>

<div class="col-sm-6 col-lg-3">
    <a href="/cast/choices">
        <div  class="card text-white bg-primary">
            <div class="card-body">
                <div>View my Choices</div>
            </div>
        </div>
    </a>
</div>

<div class="col-sm-6 col-lg-3">
    <a href="{{ url('/logout') }}">
        <div  class="card text-white bg-primary">
            <div class="card-body">
                <div>Logout</div>
            </div>
        </div>
    </a>
</div>

@endsection

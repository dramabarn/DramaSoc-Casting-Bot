@extends('dashboard.base')

@section('content')

<div id="app" class="col">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Welcome back, {{$username ?? ''}}</h3>
        </div>
    </div>
    <?php if ($showinfo['hasShow']): ?>
        <div class="row">
            <div class="col-sm">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Your Show</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Show Name</th>
                                    <td><?php echo($showinfo['name']) ?></td>
                                </tr>
                                <tr>    
                                    <th>Show Type</th>
                                    <td><?php echo($showinfo['type']) ?></td>
                                </tr>
                                <tr>
                                    <th>Show Week</th>
                                    <td><?php echo($showinfo['week']) ?></td>
                                </tr>
                                <tr>
                                    <th>Number of Roles</th>
                                    <td><?php echo($showinfo['roles']) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <list-cast v-bind:productionChoices="{{ json_encode($productionChoices ?? '') }}">
            </div>
        </div>
    
        <div class="row">
            <div class="col-sm">
                <a href="/cast/addrole">
                    <div  class="card text-white bg-primary">
                        <div class="card-body">
                            <div>Add Role</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm">
                <a href="/cast/choices">
                    <div  class="card text-white bg-primary">
                        <div class="card-body">
                            <div>View my Choices</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm">
                <a href="/cast/enter">
                <div  class="card text-white bg-primary">
                    <div class="card-body">
                        <div>Enter Casting Choice</div>
                    </div>
                </div>
                </a>
            </div>        
        </div>
    <?php endif ?>
    <div class="row">
        <div class="col-sm">
            <a href="{{ url('/logout') }}">
                <div  class="card text-white bg-primary">
                    <div class="card-body">
                        <div>Logout</div>
                    </div>
                </div>
            </a>
        </div>        
    </div>
</div>
<script src="{{ asset('js/app.js') }}" defer></script>
@endsection

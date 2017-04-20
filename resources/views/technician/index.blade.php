@extends('layouts.template')

@section('content')

<div class="panel dashboard-panel panel-default panel-transparent">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="panel with-nav-tabs panel-primary">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="{{ $tab =='pool_routes' ? ' in active' : ''}}" ><a href="#pool_routes" data-toggle="tab">Pool Routes</a></li>
                            <li class="{{ $tab =='profile' ? ' in active' : ''}}" ><a href="#profile" data-toggle="tab">Profile</a></li>                     
                        </ul>
                    </div>
                    <div class="panel-body panel-body-manager">
                        <div class="tab-content">
                            <div class="tab-pane fade {{ $tab =='pool_routes' || !$tab ? ' in active' : ''}}" id="pool_routes">Services Page</div>
                            <div class="tab-pane fade {{ $tab =='profile' ? ' in active' : ''}}" id="profile">Profile </div>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('lib')
@endsection
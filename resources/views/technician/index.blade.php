@extends('layouts.template')

@section('content')
<div class="technician index pooltab">
    <div class="container">
        <div class="row">
            <div class="col-xs">
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#pool_routes" data-toggle="tab">Pool Routes</a></li>
                                <li ><a href="#profile" data-toggle="tab">Profile Company</a></li>
                            </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="pool_routes">@include('technician.pool-route') </div>
                            <div class="tab-pane fade" id="profile">@include('technician.profile') </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br/>
@endsection

@section('lib')
@endsection
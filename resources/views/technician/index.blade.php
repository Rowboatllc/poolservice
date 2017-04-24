@extends('layouts.template')

@section('content')

<div class="panel dashboard-panel container bs-example technician">
    <div class="form-box">
        <div class="panel-heading">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#pool_routes" data-toggle="tab">Pool Routes</a></li>
                <li ><a href="#profile" data-toggle="tab">Profile Company</a></li>
            </ul>
        </div>
        <div class="panel-body panel-body-manager">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="pool_routes">@include('technician.pool-route') </div>
                <div class="tab-pane fade" id="profile">@include('technician.profile') </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('lib')
@endsection
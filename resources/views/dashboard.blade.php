@extends('layouts.template')

@section('content')

<div class="panel panel-default panel-transparent">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="panel with-nav-tabs panel-primary">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#services" data-toggle="tab">Services</a></li>
                            <li ><a href="#pool_info" data-toggle="tab">Pool Info</a></li>
                            <li ><a href="#profile" data-toggle="tab">Profile</a></li>
                            <li ><a href="#billing_info" data-toggle="tab">Billing Info</a></li>
                            <li ><a href="#service_company" data-toggle="tab">My Pool Service Company</a></li>                            
                        </ul>
                    </div>
                    <div class="panel-body panel-body-manager">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="services">Services Page</div>
                            <div class="tab-pane fade" id="pool_info">Pool Info Page</div>
                            <div class="tab-pane fade" id="profile">Profile Page</div>
                            <div class="tab-pane fade" id="billing_info">Billing Info Page</div>
                            <div class="tab-pane fade" id="service_company">My Pool Service Company Page</div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
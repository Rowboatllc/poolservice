@extends('layouts.template')

@section('content')

<div class="panel dashboard-panel panel-default panel-transparent">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="panel with-nav-tabs panel-primary">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="{{ $tab =='services' || !$tab ? ' in active' : ''}}" ><a href="#services" data-toggle="tab">Services Offered</a></li>
                            <li class="{{ $tab =='pool_routes' ? ' in active' : ''}}" ><a href="#pool_routes" data-toggle="tab">Pool Routes</a></li>
                            <li class="{{ $tab =='profile' ? ' in active' : ''}}" ><a href="#profile" data-toggle="tab">Company Profile</a></li>
                            <li class="{{ $tab =='billing_info' ? ' in active' : ''}}" ><a href="#billing_info" data-toggle="tab">Billing Info</a></li>
                            <li class="{{ $tab =='service_company' ? ' in active' : ''}}" ><a href="#service_company" data-toggle="tab">PoolService Technicians</a></li>   
                            <li class="{{ $tab =='service_company' ? ' in active' : ''}}" ><a href="#service_company" data-toggle="tab">My PoolService Customers</a></li>                                                                                 
                        </ul>
                    </div>
                    <div class="panel-body panel-body-manager">
                        <div class="tab-content">
                            <div class="tab-pane fade {{ $tab =='services' || !$tab ? ' in active' : ''}}" id="services">Services Page</div>
                            <div class="tab-pane fade {{ $tab =='pool_routes' ? ' in active' : ''}}" id="pool_routes">@include('company.poolinfo')</div>
                            <div class="tab-pane fade {{ $tab =='profile' ? ' in active' : ''}}" id="profile">@include('company.profile')</div>
                            <div class="tab-pane fade {{ $tab =='billing_info' ? ' in active' : ''}}" id="billing_info">@include('poolowner.billing-info')</div>
                            <div class="tab-pane fade {{ $tab =='service_company' ? ' in active' : ''}}" id="service_company">@include</div>
                            <div class="tab-pane fade {{ $tab =='service_company' ? ' in active' : ''}}" id="service_company">@include</div>                            
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
@extends('layouts.template')

@section('content')

<div class="poolowner index pooltab">
    <div class="container">
        <div class="row">
            <div class="col-xs">
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="{{ $tab =='services' || !$tab ? ' in active' : ''}}" ><a href="#services" data-toggle="tab">Services</a></li>
                            <li class="{{ $tab =='pool_info' ? ' in active' : ''}}" ><a href="#pool_info" data-toggle="tab">Pool Info</a></li>
                            <li class="{{ $tab =='profile' ? ' in active' : ''}}" ><a href="#profile" data-toggle="tab">Profile</a></li>
                            <li class="{{ $tab =='billing_info' ? ' in active' : ''}}" ><a href="#billing_info" data-toggle="tab">Billing Info</a></li>
                            <li class="{{ $tab =='service_company' ? ' in active' : ''}}" ><a href="#service_company" data-toggle="tab">My Pool Service Company</a></li>                            
                        </ul>
                    </div>
                    <div class="panel-body panel-body-manager">
                        <div class="tab-content">
                            <div class="tab-pane fade {{ $tab =='services' || !$tab ? ' in active' : ''}}" id="services">@include('poolowner.services')</div>
                            <div class="tab-pane fade {{ $tab =='pool_info' ? ' in active' : ''}}" id="pool_info">@include('poolowner.poolinfo')</div>
                            <div class="tab-pane fade {{ $tab =='profile' ? ' in active' : ''}}" id="profile">@include('poolowner.profile')</div>
                            <div class="tab-pane fade {{ $tab =='billing_info' ? ' in active' : ''}}" id="billing_info">@include('poolowner.billing-info')</div>
                            <div class="tab-pane fade {{ $tab =='service_company' ? ' in active' : ''}}" id="service_company">@include('poolowner.my-pool-service-company')</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('lib')
    <script src="http://parsleyjs.org/dist/parsley.js"></script>    
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>

    <script src="{{ asset('/js/register/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/js/billinginfo.js') }}"></script>
    <script src="{{ asset('/js/poolowner.js') }}"></script>
@endsection


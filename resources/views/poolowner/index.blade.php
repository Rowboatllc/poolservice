@extends('layouts.template')

@section('content')

<div class="panel dashboard-panel panel-default panel-transparent">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="panel with-nav-tabs panel-primary">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li ><a href="#services" data-toggle="tab">Services</a></li>
                            <li ><a href="#pool_info" data-toggle="tab">Pool Info</a></li>
                            <li ><a href="#profile" data-toggle="tab">Profile</a></li>
                            <li ><a href="#billing_info" data-toggle="tab">Billing Info</a></li>
                            <li class="active"><a href="#service_company" data-toggle="tab">My Pool Service Company</a></li>                            
                        </ul>
                    </div>
                    <div class="panel-body panel-body-manager">
                        <div class="tab-content">
                            <div class="tab-pane fade" id="services">Services Page</div>
                            <div class="tab-pane fade" id="pool_info">Pool Info Page</div>
                            <div class="tab-pane fade" id="profile">@include('poolowner.profile')</div>
                            <div class="tab-pane fade" id="billing_info">Billing Info Page</div>
                            <div class="tab-pane fade in active" id="service_company">@include('poolowner.my-pool-service-company')</div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('lib')
<script>
    $.fn.stars = function() {
        return $(this).each(function() {
            // Get the value
            var val = parseFloat($(this).html());
            // Make sure that the value is in 0 - 5 range, multiply to get width
            var size = Math.max(0, (Math.min(5, val))) * 16;
            // Create stars holder
            var $span = $('<span />').width(size);
            // Replace the numerical value with stars
            $(this).html($span);
        });
    }
    $(function() {
        $('span.stars').stars();
    });
</script>
@endsection

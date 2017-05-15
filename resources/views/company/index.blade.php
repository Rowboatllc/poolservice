@extends('layouts.template')

@section('content')
<div class="container panel dashboard">
    <div class="form-box">
        <ul class="nav nav-tabs">
            <li><a data-toggle="tab"  href="#sectionA">Services Offered</a></li>
            <li class="active"><a data-toggle="tab" href="#sectionB">Pool Routes</a></li>
            <li><a data-toggle="tab" href="#sectionC">Company Profile</a></li>
            <li><a data-toggle="tab" href="#sectionD">Billing Info</a></li>
            <li><a data-toggle="tab" href="#sectionE">Pool Service Professionals</a></li>
            <li><a data-toggle="tab" href="#sectionF">My PoolService Customers</a></li>
             <li><a data-toggle="tab" href="#sectionZ">offered-accept-deny</a></li>
        </ul>
        <div class="tab-content">
            <div id="sectionA" class="tab-pane fade">
                @include('company.offered-services')
            </div>
            <div id="sectionB" class="tab-pane fade in active">
                @include('company.route')
            </div>
            <div id="sectionC" class="tab-pane fade">
                @include('company.profile')
            </div>
            <div id="sectionD" class="tab-pane fade">
                @include('poolowner.billing-info')
            </div>
            <div id="sectionE" class="tab-pane fade">
                @include('company.technician')
            </div>
            <div id="sectionF" class="tab-pane fade">
                @include('company.customer')
            </div>
            <div id="sectionZ" class="tab-pane fade">
                @include('company.offered-accept-deny')
            </div>
        </div>
        </div>
        
    </div>

    
</div>
<div class="modal-wait" id="divModelPoolService"></div>

<div class="modal fade" id="notifyModalPoolService" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">        
                <form role="form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>Yoy are almost done! Please check your email at (<span id="get_your_email"><span>) 
                            and follow the instruction to completed the sign up process</label>  
                    </div>
                    <div class="form-group">
                        <button type="button" id="btnOkGotIt" class="btn btn-success">OK Got It</button>
                    </div>            
                </form>  
            </div>
        </div>
    </div>
</div>
@endsection

@section('lib')
    <script src="{{ asset('js/register/jquery.validate.min.js') }}"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
    <script src="{{ asset('js/register/main-pool-service.js') }}"></script>  
    <script src="{{ asset('/js/route-google-map.js') }}"></script>
    <script  async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBK630V18YqZgaQbViFBkYveJ_pVTfNnzI&callback=initMap" type="text/javascript"></script>
    <script src="http://parsleyjs.org/dist/parsley.js"></script>    
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>
    <script src="{{ asset('/js/billinginfo.js') }}"></script>
@endsection

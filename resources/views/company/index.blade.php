@extends('layouts.template')

@section('content')
<div class="container">
    <div class="form-box">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#sectionA">Services Offered</a></li>
            <li><a data-toggle="tab" href="#sectionB">Pool Routes</a></li>
            <li><a data-toggle="tab" href="#sectionC">Company Profile</a></li>
            <li><a data-toggle="tab" href="#sectionD">Billing Info</a></li>
            <li><a data-toggle="tab" href="#sectionE">Pool Service Technicians</a></li>
            <li><a data-toggle="tab" href="#sectionF">My PoolService Customers</a></li>
        </ul>
        <div class="tab-content">
            <div id="sectionA" class="tab-pane fade in active">
                @include('company.offered-service')
            </div>
            <div id="sectionB" class="tab-pane fade">
                <!--@include('company.route')-->
            </div>
            <div id="sectionC" class="tab-pane fade">
                @include('company.profile')
            </div>
            <div id="sectionD" class="tab-pane fade">
                <h4>Dropdown 2</h4>
                <p>Donec vel placerat quam, ut euismod risus. Sed a mi suscipit, elementum sem a, hendrerit velit. Donec at erat magna. Sed dignissim orci nec eleifend egestas. Donec eget mi consequat massa vestibulum laoreet. Mauris et ultrices nulla, malesuada volutpat ante. Fusce ut orci lorem. Donec molestie libero in tempus imperdiet. Cum sociis natoque penatibus et magnis.</p>
            </div>
            <div id="sectionE" class="tab-pane fade">
                @include('company.technician')
            </div>
            <div id="sectionF" class="tab-pane fade">
                @include('company.customer')
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
        <script src="{{ asset('js/register/main-pool-service.js') }}"></script>
@endsection

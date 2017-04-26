@extends('layouts.template')

@section('content')
<style>
    /*  bhoechie tab */
    div.bhoechie-tab-container{
    z-index: 10;
    background-color: #ffffff;
    padding: 0 !important;
    border-radius: 4px;
    -moz-border-radius: 4px;
    border:1px solid #ddd;
    margin-top: 20px;
    margin-left: 50px;
    -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
    box-shadow: 0 6px 12px rgba(0,0,0,.175);
    -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
    background-clip: padding-box;
    opacity: 0.97;
    filter: alpha(opacity=97);
    }
    div.bhoechie-tab-menu{
    padding-right: 0;
    padding-left: 0;
    padding-bottom: 0;
    }
    div.bhoechie-tab-menu div.list-group{
    margin-bottom: 0;
    }
    div.bhoechie-tab-menu div.list-group>a{
    margin-bottom: 0;
    }
    div.bhoechie-tab-menu div.list-group>a .glyphicon,
    div.bhoechie-tab-menu div.list-group>a .fa {
    color: #5A55A3;
    }
    div.bhoechie-tab-menu div.list-group>a:first-child{
    border-top-right-radius: 0;
    -moz-border-top-right-radius: 0;
    }
    div.bhoechie-tab-menu div.list-group>a:last-child{
    border-bottom-right-radius: 0;
    -moz-border-bottom-right-radius: 0;
    }
    div.bhoechie-tab-menu div.list-group>a.active,
    div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
    div.bhoechie-tab-menu div.list-group>a.active .fa{
    background-color: #5A55A3;
    background-image: #5A55A3;
    color: #ffffff;
    }
    div.bhoechie-tab-menu div.list-group>a.active:after{
    content: '';
    position: absolute;
    left: 100%;
    top: 50%;
    margin-top: -13px;
    border-left: 0;
    border-bottom: 13px solid transparent;
    border-top: 13px solid transparent;
    border-left: 10px solid #5A55A3;
    }

    div.bhoechie-tab-content{
    background-color: #ffffff;
    /* border: 1px solid #eeeeee; */
    padding-left: 20px;
    padding-top: 10px;
    }

    div.bhoechie-tab div.bhoechie-tab-content:not(.active){
    display: none;
    }
    .is-disabled {
        pointer-events: none;   
    }
    .divLoadData {
        display: none;
        padding-top:10px;
    }

    img {
        max-width: 100%;
        max-height: 100%;
    }

    .portrait {
        height: 80px;
        width: 30px;
    }
</style>
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
                <h3>Section B</h3>
                <p>Vestibulum nec erat eu nulla rhoncus fringilla ut non neque. Vivamus nibh urna, ornare id gravida ut, mollis a magna. Aliquam porttitor condimentum nisi, eu viverra ipsum porta ut. Nam hendrerit bibendum turpis, sed molestie mi fermentum id. Aenean volutpat velit sem. Sed consequat ante in rutrum convallis. Nunc facilisis leo at faucibus adipiscing.</p>
            </div>
            <div id="sectionC" class="tab-pane fade">
                @if($comProfile->wq)
                    <div class="row sectionC2">
                        <div class="select-data col-sm-4">
                            <select id="review_select" name="review_select" >
                                <option selected="selected">Awaiting Verification</option>
                                @if($comProfile->approved)
                                    <option value="wq">W-q</option>
                                    <option value="driver_license">Driver's License</option>
                                    <option value="cpa">cpa</option>
                                @else
                                    <option value="wq">W-q</option>
                                    <option value="driver_license">Driver's License</option>
                                    <option value="cpa">cpa</option>
                                @endif                            
                            </select>
                        </div>
                        <div class="logo-data col-sm-4">
                            <img src="{{$comProfile->logo}}">
                        </div>
                        <div class="address-data col-sm-4">
                            
                        </div>
                    </div>                    
                @else
                    <div class="row sectionC1 divLoadData">
                        <form role="form" id="frmPoolServiceDashBoard" action="{{route('upload-company-profile')}}" method="post" class="f2" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="col-lg-5 col-md-5 col-sm-8 col-xs-9 bhoechie-tab-container">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
                                    <div class="list-group">
                                        <a href="#" class="list-group-item active text-center is-disabled">
                                            <h4 class="glyphicon glyphicon-plane"></h4><br/>Company Logo
                                        </a>
                                        <a href="#" class="list-group-item text-center is-disabled">
                                            <h4 class="glyphicon glyphicon-road"></h4><br/>W-q
                                        </a>
                                        <a href="#" class="list-group-item text-center is-disabled">
                                            <h4 class="glyphicon glyphicon-home"></h4><br/>Driver's' Lisense
                                        </a>
                                        <a href="#" class="list-group-item text-center is-disabled">
                                            <h4 class="glyphicon glyphicon-cutlery"></h4><br/>CPA Certification
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                                    <!-- flight section -->
                                    <div class="form-group bhoechie-tab-content active">
                                        <center>
                                            <!--<h4 class="glyphicon glyphicon-plane" style="font-size:14em;color:#55518a"></h4>-->
                                            <h4 style="margin-top: 0;color:#55518a">Upload your company logo</h4>
                                            <input type="file" id="file_logo" required name="logo" value="" required placeholder="upload your logo..." class="form-control">
                                            <span class="portrait" id="preview_logo"></span>
                                            <h4 style="margin-top: 0;color:#55518a">Why is this necessary?</h4>
                                            <h4 style="margin-top: 0;color:#55518a">it's not but it help you stand out from the crowd</h4>
                                            <div class="buttons">
                                                <button type="button" class="btn btn-next-info">Next</button>
                                            </div>
                                        </center>                            
                                    </div>
                                    <!-- train section -->
                                    <div class="form-group bhoechie-tab-content">
                                        <center>
                                            <!--<h4 class="glyphicon glyphicon-road" style="font-size:12em;color:#55518a"></h4>-->
                                            <h4 style="margin-top: 0;color:#55518a">Upload your W-q</h4>
                                            <h4 style="margin-top: 0;color:#55518a">https:www.irs.gov/pub/irs-pdf/fwq.pdf</h4>
                                            <input type="file" required name="wq" value="" required placeholder="Upload your W-q..." class="form-control" id="file_wq">
                                            <span class="portrait" id="preview_wq"></span>
                                            <h4 style="margin-top: 0;color:#55518a">Why is this necessary?</h4>
                                            <h4 style="margin-top: 0;color:#55518a">You are considered a subcontractor of PoolService.com and will receive a </h4>
                                            <h4 style="margin-top: 0;color:#55518a">MISC-1099 from PoolService.com after the end of the year</h4>
                                            <div class="buttons">
                                                <button type="button" class="btn btn-previous">Back</button>
                                                <button type="button" class="btn btn-next-info">Next</button>
                                            </div>
                                        </center>
                                    </div>
                        
                                    <!-- hotel search -->
                                    <div class="form-group bhoechie-tab-content">
                                        <center>
                                            <!--<h4 class="glyphicon glyphicon-home" style="font-size:12em;color:#55518a"></h4>-->
                                            <h4 style="margin-top: 0;color:#55518a">Upload a scan og your driver's license</h4>
                                            <input type="file" required name="driven_license" value="" required placeholder="Upload your driven license..." class="form-control" id="file_driven_license">
                                            <span class="portrait" id="preview_driven_license"></span>
                                            <h4 style="margin-top: 0;color:#55518a">Why is this necessary?</h4>
                                            <h4 style="margin-top: 0;color:#55518a">This helps us to verify who you say you are.</h4>
                                            <div class="buttons">
                                                <button type="button" class="btn btn-previous">Back</button>
                                                <button type="button" class="btn btn-next-info">Next</button>
                                            </div>
                                        </center>
                                    </div>
                                    <div class="form-group bhoechie-tab-content">
                                        <center>
                                            <!--<h4 class="glyphicon glyphicon-cutlery" style="font-size:12em;color:#55518a"></h4>-->
                                            <h4 style="margin-top: 0;color:#55518a">Upload a scan of CPA certification</h4>
                                            <input type="file" name="cpa" value="" required placeholder="Upload your CPA..." class="form-control" id="file_cpa">
                                            <span class="portrait" id="preview_cpa"></span>
                                            <h4 style="margin-top: 0;color:#55518a">Why is this necessary?</h4>
                                            <h4 style="margin-top: 0;color:#55518a">This is optional. In order to service commercial pools, you must be CPA certified.</h4>
                                            <h4 style="margin-top: 0;color:#55518a">If you are not CPA certified, you can skip this step.</h4>
                                            <div class="buttons">
                                                <button type="button" class="btn btn-previous">Back</button>
                                                <button type="submit" class="btn btn-submit">Submit</button>
                                            </div>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif  
            </div>
            <div id="sectionD" class="tab-pane fade">
                <h4>Dropdown 2</h4>
                <p>Donec vel placerat quam, ut euismod risus. Sed a mi suscipit, elementum sem a, hendrerit velit. Donec at erat magna. Sed dignissim orci nec eleifend egestas. Donec eget mi consequat massa vestibulum laoreet. Mauris et ultrices nulla, malesuada volutpat ante. Fusce ut orci lorem. Donec molestie libero in tempus imperdiet. Cum sociis natoque penatibus et magnis.</p>
            </div>
            <div id="sectionE" class="tab-pane fade">
                <h4>Dropdown 2</h4>
                <p>Donec vel placerat quam, ut euismod risus. Sed a mi suscipit, elementum sem a, hendrerit velit. Donec at erat magna. Sed dignissim orci nec eleifend egestas. Donec eget mi consequat massa vestibulum laoreet. Mauris et ultrices nulla, malesuada volutpat ante. Fusce ut orci lorem. Donec molestie libero in tempus imperdiet. Cum sociis natoque penatibus et magnis.</p>
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
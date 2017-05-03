<div class="company-profile-service">
    <div class="row sectionC2 {{ $comProfile->wq==null ? 'divLoadData' : '' }}">
    </br>
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
            <img src="{{ $comProfile->logo }}">
        </div>
        <div class="address-data col-sm-4">
            <table class="table table-hover table-bordered" id="infoTable">
                <tr>
                    <td>Company Name</td>
                    <td>{{$comProfile->name}}</td>
                </tr>
                <tr>
                    <td>Website</td>
                    <td>{{$comProfile->website}}</td>
                </tr>
                <tr>
                    <td>First and Last Name</td>
                    <td>{{$comProfile->fullname}}</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>{{$comProfile->address}}</td>
                </tr>
                <tr>
                    <td>Telephone Number</td>
                    <td>{{$comProfile->phone}}</td>
                </tr>
            </table>
        </div>
    </div>  
    <div class="row sectionC1 {{ $comProfile->wq==null ? '' : 'divLoadData' }}">
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
</div>
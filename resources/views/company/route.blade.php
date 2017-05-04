<div class="company-route-service">    
    <div class="row sectionB1">
        <form role="form" id="frmPoolServiceRoute" action="{{route('upload-company-profile')}}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-xs-11 route-tab-container">
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 route-tab-menu">
                    <div class="list-group">
                        <a href="#" class="list-group-item active text-center">
                            <h4 class="glyphicon glyphicon-plane"></h4><br/>Monday
                        </a>
                        <a href="#" class="list-group-item text-center">
                            <h4 class="glyphicon glyphicon-road"></h4><br/>Tuesday
                        </a>
                        <a href="#" class="list-group-item text-center">
                            <h4 class="glyphicon glyphicon-home"></h4><br/>Wednesday
                        </a>
                        <a href="#" class="list-group-item text-center">
                            <h4 class="glyphicon glyphicon-cutlery"></h4><br/>Thursday
                        </a>
                        <a href="#" class="list-group-item text-center">
                            <h4 class="glyphicon glyphicon-roundabout"></h4><br/>Friday
                        </a>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 route-tab">
                    <div class="form-group route-tab-content active">
                        <div class="row">
                            <div class="col-sm-10">
                                <h4 style="margin-top: 0;color:#55518a">You currently have no routes list on Monday</h4>
                                <h4 style="margin-top: 0;color:#55518a">If you are not available to service pool on Monday, check "Not available" box</h4>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group" >                        
                                    <input type="checkbox" name="chk_monday" value="spa" id="chk_monday" class="chk-monday">
                                    <label for="chk-weekly-spa" id=lblMonday>Not Available</label>
                                </div>
                            </div>
                        </div>                     
                    </div>

                    <div class="form-group route-tab-content">
                        <div class="row">
                            <div class="col-sm-10">
                                <h4 style="margin-top: 0;color:#55518a">If you are not available to service pool on Monday, check "Not available" box</h4>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group" >                        
                                    <input type="checkbox" name="chk_tuesday" id="chk_tuesday" class="chk_tuesday">
                                    <label for="chk_tuesday" id=lblTuesday>Not Available</label>
                                </div>
                            </div>
                        </div>   
                        <div class="row">
                            <div class="form-inline">
                                <div class="form-group">
                                    <img src="{{ $user->avatar }}">
                                    <label>{{$user->name}}</label>
                                </div>
                                <!--<div class="form-group">
                                    <select id="pool_service_list" name="pool_service_list" >
                                        <option selected="selected">Chose pool service professional</option>
                                        @if($user)
                                            <option value="wq" data-class="ui-icon-circle-check">W-q</option>
                                            <option value="driver_license" data-class="ui-icon-circle-check">Driver's License</option>
                                            <option value="cpa" data-class="ui-icon-circle-check">cpa</option>
                                        @endif                            
                                    </select>
                                </div>-->
                            </div>
                        </div> 

                        <div class="row">
                            <table class="table table-hover">
                                <tr>
                                    <th><a></a></th>
                                    <th><a>Order</a></th>
                                    <th><a>Street Address</a></th>
                                    <th><a>City</a></th>
                                    <th><a>Zipcode</a></th>
                                </tr>
                                @foreach ($routes as $route)
                                    <tr>	
                                        <td></td>
                                        <td>{{$route->address}}</td>
                                        <td>{{$route->address}}</td>
                                        <td>{{$route->city}}</td>
                                        <td>{{$route->zipcode}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div> 
                    </div>

                    <div class="form-group route-tab-content">
                    </div>
                    <div class="form-group route-tab-content">
                    </div>

                    <div class="form-group route-tab-content">
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 route-tab">
                    <div class="panel panel-default">
                        <div class="text-center header">Route Map</div>
                        <div class="panel-body text-center">
                            <div id="route-map" class="route-map"></div>
                            &nbsp;
                            <div id="route-warnings-panel"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
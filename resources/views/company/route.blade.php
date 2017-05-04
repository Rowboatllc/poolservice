
<div class="company-route-service">    
    <div class="sectionB1">
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
            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 route-tab">
                <div class="form-group route-tab-content active">
                    <div class="col-md-12">
                        <div class="col-sm-8">
                            <h4 style="margin-top: 0;color:#55518a">You currently have no routes list on Monday</h4>
                            <h4 style="margin-top: 0;color:#55518a">If you are not available to service pool on Monday, check "Not available" box</h4>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" >                        
                                <input type="checkbox" name="chk_monday" value="spa" id="chk_monday" class="chk-monday">
                                <label for="chk-weekly-spa" id=lblMonday>Not Available</label>
                            </div>
                        </div>
                    </div>    
                    <div class="col-md-12">
                        <div class="form-inline">
                            <div class="form-group">
                                <img class="circle-image" src="/company-image/1.png">
                                <label>{{$user->name}}</label>
                            </div>
                            <div class="form-group">
                                <select id="pool_service_list" name="pool_service_list" >
                                    <option selected="selected">Chose pool service professional</option>
                                    @if($user)
                                        <option value="wq" data-class="ui-icon-circle-check">user 1</option>
                                        <option value="driver_license" data-class="ui-icon-circle-check">user 2</option>
                                        <option value="cpa" data-class="ui-icon-circle-check">user 3</option>
                                    @endif                            
                                </select>
                            </div>
                        </div>
                    </div> 

                    <div>
                        <div class="col-md-7">
                            <table class="table table-hover">
                                <tr>
                                    <th><a>Order</a></th>
                                    <th><a>Street Address</a></th>
                                    <th><a>City</a></th>
                                    <th><a>Zipcode</a></th>
                                </tr>
                                @foreach ($routes as $route)
                                    <tr>	
                                        <td>{{$route->address}}</td>
                                        <td>{{$route->address}}</td>
                                        <td>{{$route->city}}</td>
                                        <td>{{$route->zipcode}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div> 
                        <div class="col-md-5">
                            <div class="panel">
                                <div class="text-center header">Route Map</div>
                                <div class="panel-body text-center">
                                    <div id="route-map" style="width: 320px; height: 400px;" class="route-map"></div>
                                </div>
                            </div>
                        </div>
                    </div>                  
                </div>

                <div class="form-group route-tab-content">
                    <div class="col-md-12">
                        <div class="col-sm-8">
                            <h4 style="margin-top: 0;color:#55518a">If you are not available to service pool on Monday, check "Not available" box</h4>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" >                        
                                <input type="checkbox" name="chk_tuesday" id="chk_tuesday" class="chk_tuesday">
                                <label for="chk_tuesday" id=lblTuesday>Not Available</label>
                            </div>
                        </div>
                    </div>   
                    <div class="col-md-12">
                        <div class="form-inline">
                            <div class="form-group">
                                <img class="img-responsive cattoBorderRadius" src="{{ $user->avatar }}">
                                <label>{{$user->name}}</label>
                            </div>
                            <div class="form-group">
                                <select id="pool_service_list" name="pool_service_list" >
                                    <option selected="selected">Chose pool service professional</option>
                                    @if($user)
                                        <option value="wq" data-class="ui-icon-circle-check">user 1</option>
                                        <option value="driver_license" data-class="ui-icon-circle-check">user 2</option>
                                        <option value="cpa" data-class="ui-icon-circle-check">user 3</option>
                                    @endif                            
                                </select>
                            </div>
                        </div>
                    </div> 

                    <div>
                        <div class="col-md-7">
                            <table class="table table-hover">
                                <tr>
                                    <th><a>Order</a></th>
                                    <th><a>Street Address</a></th>
                                    <th><a>City</a></th>
                                    <th><a>Zipcode</a></th>
                                </tr>
                                @foreach ($routes as $route)
                                    <tr>	
                                        <td>{{$route->address}}</td>
                                        <td>{{$route->address}}</td>
                                        <td>{{$route->city}}</td>
                                        <td>{{$route->zipcode}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div> 
                        <div class="col-md-5">
                            <div class="panel">
                                <div class="text-center header">Route Map</div>
                                <div class="panel-body text-center">
                                    <div id="route-map" style="width: 320px; height: 400px;" class="route-map"></div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>

                <div class="form-group route-tab-content">
                    <div class="col-md-12">
                        <div class="col-sm-8">
                            <h4 style="margin-top: 0;color:#55518a">If you are not available to service pool on Monday, check "Not available" box</h4>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" >                        
                                <input type="checkbox" name="chk_tuesday" id="chk_tuesday" class="chk_tuesday">
                                <label for="chk_tuesday" id=lblTuesday>Not Available</label>
                            </div>
                        </div>
                    </div>   
                    <div class="col-md-12">
                        <div class="form-inline">
                            <div class="form-group">
                                <img class="img-responsive cattoBorderRadius" src="{{ $user->avatar }}">
                                <label>{{$user->name}}</label>
                            </div>
                            <div class="form-group">
                                <select id="pool_service_list" name="pool_service_list" >
                                    <option selected="selected">Chose pool service professional</option>
                                    @if($user)
                                        <option value="wq" data-class="ui-icon-circle-check">user 1</option>
                                        <option value="driver_license" data-class="ui-icon-circle-check">user 2</option>
                                        <option value="cpa" data-class="ui-icon-circle-check">user 3</option>
                                    @endif                            
                                </select>
                            </div>
                        </div>
                    </div> 

                    <div>
                        <div class="col-md-7">
                            <table class="table table-hover">
                                <tr>
                                    <th><a>Order</a></th>
                                    <th><a>Street Address</a></th>
                                    <th><a>City</a></th>
                                    <th><a>Zipcode</a></th>
                                </tr>
                                @foreach ($routes as $route)
                                    <tr>	
                                        <td>{{$route->address}}</td>
                                        <td>{{$route->address}}</td>
                                        <td>{{$route->city}}</td>
                                        <td>{{$route->zipcode}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div> 
                        <div class="col-md-5">
                            <div class="panel">
                                <div class="text-center header">Route Map</div>
                                <div class="panel-body text-center">
                                    <div id="route-map" style="width: 320px; height: 400px;" class="route-map"></div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="form-group route-tab-content">
                    <div class="col-md-12">
                        <div class="col-sm-8">
                            <h4 style="margin-top: 0;color:#55518a">If you are not available to service pool on Monday, check "Not available" box</h4>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" >                        
                                <input type="checkbox" name="chk_tuesday" id="chk_tuesday" class="chk_tuesday">
                                <label for="chk_tuesday" id=lblTuesday>Not Available</label>
                            </div>
                        </div>
                    </div>   
                    <div class="col-md-12">
                        <div class="form-inline">
                            <div class="form-group">
                                <img class="img-responsive cattoBorderRadius" src="{{ $user->avatar }}">
                                <label>{{$user->name}}</label>
                            </div>
                            <div class="form-group">
                                <select id="pool_service_list" name="pool_service_list" >
                                    <option selected="selected">Chose pool service professional</option>
                                    @if($user)
                                        <option value="wq" data-class="ui-icon-circle-check">user 1</option>
                                        <option value="driver_license" data-class="ui-icon-circle-check">user 2</option>
                                        <option value="cpa" data-class="ui-icon-circle-check">user 3</option>
                                    @endif                            
                                </select>
                            </div>
                        </div>
                    </div> 

                    <div>
                        <div class="col-md-7">
                            <table class="table table-hover">
                                <tr>
                                    <th><a>Order</a></th>
                                    <th><a>Street Address</a></th>
                                    <th><a>City</a></th>
                                    <th><a>Zipcode</a></th>
                                </tr>
                                @foreach ($routes as $route)
                                    <tr>
                                        <td>{{$route->address}}</td>
                                        <td>{{$route->address}}</td>
                                        <td>{{$route->city}}</td>
                                        <td>{{$route->zipcode}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div> 
                        <div class="col-md-5">
                            <div class="panel">
                                <div class="text-center header">Route Map</div>
                                <div class="panel-body text-center">
                                    <div id="route-map" style="width: 320px; height: 400px;" class="route-map"></div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>

                <div class="form-group route-tab-content">
                    <div class="col-md-12">
                        <div class="col-sm-8">
                            <h4 style="margin-top: 0;color:#55518a">If you are not available to service pool on Monday, check "Not available" box</h4>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" >                        
                                <input type="checkbox" name="chk_tuesday" id="chk_tuesday" class="chk_tuesday">
                                <label for="chk_tuesday" id=lblTuesday>Not Available</label>
                            </div>
                        </div>
                    </div>   
                    <div class="col-md-12">
                        <div class="form-inline">
                            <div class="form-group">
                                <img src="{{ $user->avatar }}">
                                <label>{{$user->name}}</label>
                            </div>
                            <div class="form-group">
                                <select id="pool_service_list" name="pool_service_list" >
                                    <option selected="selected">Chose pool service professional</option>
                                    @if($user)
                                        <option value="wq" data-class="ui-icon-circle-check">user 1</option>
                                        <option value="driver_license" data-class="ui-icon-circle-check">user 2</option>
                                        <option value="cpa" data-class="ui-icon-circle-check">user 3</option>
                                    @endif                            
                                </select>
                            </div>
                        </div>
                    </div> 

                    <div>
                        <div class="col-md-7">
                            <table class="table table-hover">
                                <tr>
                                    <th><a>Order</a></th>
                                    <th><a>Street Address</a></th>
                                    <th><a>City</a></th>
                                    <th><a>Zipcode</a></th>
                                </tr>
                                @foreach ($routes as $route)
                                    <tr>
                                        <td>{{$route->address}}</td>
                                        <td>{{$route->address}}</td>
                                        <td>{{$route->city}}</td>
                                        <td>{{$route->zipcode}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div> 
                        <div class="col-md-5">
                            <div class="panel">
                                <div class="text-center header">Route Map</div>
                                <div class="panel-body text-center">
                                    <div id="route-map" style="width: 320px; height: 400px;" class="route-map"></div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
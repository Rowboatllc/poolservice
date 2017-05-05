
<div class="company-route-service">    
    <div class="sectionB1">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-xs-11 route-tab-container">
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 route-tab-menu">
                <div class="list-group">
                    @foreach ($dates as $key => $value)
                        <a href="#" id="{{$value}}" class="list-group-item {{$key==$currentDate? 'active': ''}}  text-center">
                            {{$key}}
                        </a>
                    @endforeach
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
                            </div>
                            <div class="form-group">
                                <label>{{$user->name}}</label>
                            </div>
                            <div class="form-group">
                                <select id="pool_service_list" name="pool_service_list" >
                                    <option selected="selected">Chose pool service professional</option>
                                    @foreach ($technicians as $tech)
                                        <option value="{{$tech->id}}" data-class="ui-icon-circle-check">{{$tech->fullname}}</option>
                                    @endforeach                            
                                </select>
                            </div>

                            <div class="form-group">
                                <label>{{count($day1)}} pools</label>
                            </div>
                        </div>
                    </div> 

                    <div>
                        <div class="col-md-7">
                            <table class="table table-hover">
                                <tr>
                                    <th></th>
                                    <th><a>Order</a></th>
                                    <th><a>Street Address</a></th>
                                    <th><a>City</a></th>
                                    <th><a>Zipcode</a></th>
                                </tr>
                                @foreach ($day1 as $route)
                                    <tr>	
                                        <td><input type="checkbox" checked></input></td>
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
                            </div>

                            <div class="form-group">
                                <label>{{$user->name}}</label>
                            </div>
                            <div class="form-group">
                                <select id="pool_service_list" name="pool_service_list" >
                                    <option selected="selected">Chose pool service professional</option>
                                    @foreach ($technicians as $tech)
                                        <option value="{{$tech->id}}" data-class="ui-icon-circle-check">{{$tech->fullname}}</option>
                                    @endforeach                              
                                </select>
                            </div>

                            <div class="form-group">
                                <label>{{count($day2)}} pools</label>
                            </div>
                        </div>
                    </div> 

                    <div>
                        <div class="col-md-7">
                            <table class="table table-hover">
                                <tr>
                                    <th></th>
                                    <th><a>Order</a></th>
                                    <th><a>Street Address</a></th>
                                    <th><a>City</a></th>
                                    <th><a>Zipcode</a></th>
                                </tr>
                                @foreach ($day2 as $route)
                                    <tr>	
                                        <td><input type="checkbox" checked></input></td>
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
                            </div>
                            <div class="form-group">
                                <label>{{$user->name}}</label>
                            </div>
                            <div class="form-group">
                                <select id="pool_service_list" name="pool_service_list" >
                                    <option selected="selected">Chose pool service professional</option>
                                    @foreach ($technicians as $tech)
                                        <option value="{{$tech->id}}" data-class="ui-icon-circle-check">{{$tech->fullname}}</option>
                                    @endforeach                               
                                </select>
                            </div>

                            <div class="form-group">
                                <label>{{count($day3)}} pools</label>
                            </div>
                        </div>
                    </div> 

                    <div>
                        <div class="col-md-7">
                            <table class="table table-hover">
                                <tr>
                                    <th></th>
                                    <th><a>Order</a></th>
                                    <th><a>Street Address</a></th>
                                    <th><a>City</a></th>
                                    <th><a>Zipcode</a></th>
                                </tr>
                                @foreach ($day3 as $route)
                                    <tr>	
                                        <td><input type="checkbox" checked></input></td>
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
                            </div>
                            <div class="form-group">
                                <label>{{$user->name}}</label>
                            </div>
                            <div class="form-group">
                                <select id="pool_service_list" name="pool_service_list" >
                                    <option selected="selected">Chose pool service professional</option>
                                    @foreach ($technicians as $tech)
                                        <option value="{{$tech->id}}" data-class="ui-icon-circle-check">{{$tech->fullname}}</option>
                                    @endforeach                              
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{count($day4)}} pools</label>
                            </div>
                        </div>
                    </div> 

                    <div>
                        <div class="col-md-7">
                            <table class="table table-hover">
                                <tr>
                                    <th></th>
                                    <th><a>Order</a></th>
                                    <th><a>Street Address</a></th>
                                    <th><a>City</a></th>
                                    <th><a>Zipcode</a></th>
                                </tr>
                                @foreach ($day4 as $route)
                                    <tr>
                                        <td><input type="checkbox" checked></input></td>
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
                            </div>
                            <div class="form-group">
                                <label>{{$user->name}}</label>
                            </div>
                            <div class="form-group">
                                <select id="pool_service_list" name="pool_service_list" >
                                    <option selected="selected">Chose pool service professional</option>
                                    @foreach ($technicians as $tech)
                                        <option value="{{$tech->id}}" data-class="ui-icon-circle-check">{{$tech->fullname}}</option>
                                    @endforeach                                 
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{count($day5)}} pools</label>
                            </div>
                        </div>
                    </div> 

                    <div>
                        <div class="col-md-7">
                            <table class="table table-hover">
                                <tr>
                                    <th></th>
                                    <th><a>Order</a></th>
                                    <th><a>Street Address</a></th>
                                    <th><a>City</a></th>
                                    <th><a>Zipcode</a></th>
                                </tr>
                                @foreach ($day5 as $route)
                                    <tr>
                                        <td><input type="checkbox" checked></input></td>
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
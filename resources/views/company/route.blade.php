<div class="company-route-service">    
    <div class="sectionB1">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-xs-12 route-tab-container">
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 route-tab-menu">
                <div class="list-group-route">
                    @foreach ($dates as $key => $value)
                        <a href="#" id="tab_{{$key}}" class="list-group-item text-center {{$key==$currentDate? 'active': ''}}">
                            {{$key}}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 route-tab">
                @foreach ($dates as $key => $value)
                    <div class="form-group route-tab-content {{$key==$currentDate? 'active': ''}}">                                         
                        <div class="col-md-12">
                            <div class="col-sm-8">
                                @if(count($value)<=0)
                                    <h4>You currently have no routes list on {{$key}}</h4>
                                @else
                                    <h4>If you are not available to service pool on {{$key}}, check "Not available" box</h4>
                                @endif
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group" >                        
                                    <input type="checkbox" name="chk_{{$key}}" date="{{$key}}" id="chk_{{$key}}" class="chk-not-available">
                                    <label for="chk-{{$key}}" id=lbl{{$key}}>Not Available</label>
                                </div>
                            </div>
                        </div>                          
                        @if(count($value)>0)   
                            <div class="form-inline">
                                <div class="form-group">
                                    <img class="circle-image avatar-{{$key}}" src="/company-image/1.png">
                                </div>
                                <div class="form-group">
                                    <label class="user-name-{{$key}}">{{$user->name}}</label>
                                    <label class="hidden user-address-{{$key}}">{{$user->address}}</label>
                                    <label class="hidden user-lat-{{$key}}">{{$user->lat}}</label>
                                    <label class="hidden user-lng-{{$key}}">{{$user->lng}}</label>
                                    <label class="hidden not-asign-{{$key}}">Not asigned</label>
                                </div>
                                <div class="form-group">
                                    <select id="{{$key}}" name="pool_service_list_{{$key}}">
                                        <option value="0" selected="selected">Chose pool service professional</option>
                                        @foreach ($listTechnicians as $tech)
                                            <option value="{{$tech->user_id}}" data-class="ui-icon-circle-check">{{$tech->fullname}}</option>
                                        @endforeach                            
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label id="count_route">{{count($value)}} pools</label>
                                </div>
                            </div>
                            <div>
                                <table class="table table-striped table-hover table-route-{{$key}} {{$key==$currentDate? 'table-active': ''}}">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th><a>Order</a></th>
                                            <th><a>Street Address</a></th>
                                            <th><a>City</a></th>
                                            <th><a>Zipcode</a></th>
                                            <th><a>Service Completed</a></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($value as $key_route => $route)
                                            <tr>	
                                                <td><input type="checkbox" checked></input></td>
                                                <td>{{$key_route+1}}</td>
                                                <td class="address-to-route">{{$route->address}}</td>
                                                <td>{{$route->city}}</td>
                                                <td>{{$route->zipcode}}</td>
                                                <td class="fa fa-check-circle fa-6 status">{{$route->status}}</td>
                                                <td class="fullname-to-route hidden">{{$route->fullname}}</td>
                                                <td class="lat-to-route hidden">{{$route->lat}}</td>
                                                <td class="lng-to-route hidden">{{$route->lng}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>                                
                            </div>  
                        @endif                
                    </div>
                @endforeach
            </div>

            <div class="panel">
                <div class="text-center header title-route-map">{{$currentDate}} Route Map</div>
                <div class="panel-body text-center">
                    <div id="route-map" class="route-map"></div>
                    <div id="directions_panel"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="company-route-service">    
    <div class="sectionB1">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-xs-11 route-tab-container">
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 route-tab-menu">
                <div class="list-group">
                    @foreach ($dates as $key => $value)
                        <a href="#" id="tab_{{$key}}" class="list-group-item {{$key==$currentDate? 'active': ''}}  text-center">
                            {{$key}}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 route-tab">
                @foreach ($dates as $key => $value)
                    <div class="form-group route-tab-content {{$key==$currentDate? 'active': ''}}">                                         
                        <div class="col-md-12">
                            <div class="col-sm-8">
                                <h4 style="margin-top: 0;color:#55518a">You currently have no routes list on {{$key}}</h4>
                                <h4 style="margin-top: 0;color:#55518a">If you are not available to service pool on {{$key}}, check "Not available" box</h4>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group" >                        
                                    <input type="checkbox" name="chk_{{$key}}" date="{{$key}}" id="chk_{{$key}}" class="chk-not-available">
                                    <label for="chk-{{$key}}" id=lbl{{$key}}>Not Available</label>
                                </div>
                            </div>
                        </div>                          
                        @if(count($value)>0)   
                            <div class="col-md-12">
                                <div class="form-inline">
                                    <div class="form-group">
                                        <img class="circle-image avatar-{{$key}}" src="/company-image/1.png">
                                    </div>
                                    <div class="form-group">
                                        <label class="name-{{$key}}">{{$user->name}}</label>
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
                            </div> 

                            <div>
                                <div class="col-md-7">
                                    <table class="table table-hover table-route-{{$key}} {{$key==$currentDate? 'table-active': ''}}">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th><a>Order</a></th>
                                                <th><a>Street Address</a></th>
                                                <th><a>City</a></th>
                                                <th><a>Zipcode</a></th>
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
                                                    <td class="fullname-to-route hidden">{{$route->fullname}}</td>
                                                    <td class="lat-to-route hidden">{{$route->lat}}</td>
                                                    <td class="lng-to-route hidden">{{$route->lng}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> 
                                <div class="col-md-5 route-map-{{$key}}">
                                    <div class="panel">
                                        <div class="text-center header">{{$key}} Route Map</div>
                                        <div class="panel-body text-center">
                                            <div id="route-map" style="width: 100%; height: 400px; display:loat;border: 1px solid #3872ac;" class="route-map"></div>
                                            <div id="directions_panel"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        @endif                
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
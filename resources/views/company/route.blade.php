<div class="company-route-service">  
    <div class="sectionB1">
        <div align="right"><span id="lbl_history">History</span> <i class="glyphicon glyphicon-calendar btn-history-route"></i></div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-xs-12 route-tab-container">
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 route-tab-menu">
                <div class="list-group-route">
                    @foreach ($dates as $key => $value)
                        <a href="#" id="tab-{{$key}}" class="list-group-item text-center {{$key==$currentDate? 'active': ''}}">
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
                                @if(count($value)>0)
                                    <h4>If you are not available to service pool on {{$key}}, check "Not available" box</h4>
                                @else                                    
                                    <h4>You currently have no routes list on {{$key}}</h4>
                                @endif
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group" >                        
                                    <input type="checkbox" name="chk-{{$key}}" date="{{$key}}" id="chk-{{$key}}" class="chk-not-available">
                                    <label for="chk-{{$key}}" id=lbl{{$key}}>Not Available</label>
                                </div>
                            </div>
                        </div>                          
                        @if(count($value)>0)   
                            <div class="form-inline">
                                <div class="form-group">
                                    <img class="circle-image avatar-{{$key}}" src="{{$user->avatar}}">
                                </div>
                                <div class="form-group">
                                    <label class="user-name-{{$key}}">{{$user->name}}</label>
                                </div>
                                <div class="form-group">
                                    <select id="{{$key}}" class="pool-service-technician-list" name="pool-service-list-{{$key}}">
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
                            <div class="panel panel-default">
                                <table class="table table-hover table-route-{{$key}} {{$key==$currentDate? 'table-active': ''}}">
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
                                                <td ><i class="fa fa-check-square  {{$route->status=='billing_error'|| $route->status=='billing_success'?'icon-success':''}}" aria-hidden="true"></i></td>
                                                <td class="fullname-to-route hidden">{{$route->fullname}}</td>
                                                <td class="lat-to-route hidden">{{$route->lat}}</td>
                                                <td class="lng-to-route hidden">{{$route->lng}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>  
                                <div class="panel-footer text-center total-route-date">You have: <strong>{{count($value)}} routes</strong> for <strong>{{$key}}</strong>
                                </div>                              
                            </div>  
                        @endif     
                        </br>
                        @if(count($scheduleNotAsign)>0)   
                            <div class="form-inline">
                                <div class="form-group">
                                    
                                </div>
                                <div class="form-group">
                                    <label class="user-name-not-asign-{{$key}}">Not Assigned</label>
                                </div>
                                <div class="form-group">
                                    <select id="not-asign-{{$key}}" class="pool-service-technician-not-asign-list" name="pool-service-list-not-asign-{{$key}}">
                                        <option value="0" selected="selected">Chose pool service professional</option>
                                        @foreach ($listTechnicians as $tech)
                                            <option value="{{$tech->user_id}}" data-class="ui-icon-circle-check">{{$tech->fullname}}</option>
                                        @endforeach                            
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label id="count_route-not-asign">{{count($scheduleNotAsign)}} pools</label>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <table class="table table-hover table-route-not-asign-{{$key}}">
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
                                        @foreach ($scheduleNotAsign as $key_che => $che)
                                            <tr>	
                                                <td><input type="checkbox" checked></input></td>
                                                <td>{{$key_che+1}}</td>
                                                <td class="address-to-route">{{$che->address}}</td>
                                                <td>{{$che->city}}</td>
                                                <td>{{$che->zipcode}}</td>
                                                <td ></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>  
                                <div class="panel-footer text-center total-route-date-not-asign">You have: <strong>{{count($scheduleNotAsign)}} routes </strong>not assign <strong>yet</strong>
                                </div>                              
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


        <div class="panel panel-default route-calendar hidden">
            <div class="panel-body">
                <div class="calendar fc fc-ltr">
                    <div align="center">  
                        <ul class="list-inline">
                            <li><i class="fa fa-chevron-circle-left btn-load-monthly-view last-month" aria-hidden="true"></i></li>
                            <li><h2 id="current-month-year">{{$currentMonthYear}}</h2></li>
                            <li><i class="fa fa-chevron-circle-right btn-load-monthly-view next-month" aria-hidden="true"></i></li>
                        </ul>
                    </div> 
                    <div class="fc-content" style="position: relative; min-height: 1px;">
                        <div class="fc-view fc-view-month fc-grid" style="position: relative; min-height: 1px;" unselectable="on">
                            
                            <table class="fc-border-separate" id="table-calendar-history" style="width:100%" cellspacing="0">
                                <thead>
                                    <tr class="fc-first fc-last">
                                        <th class="fc-day-header fc-sun fc-widget-header fc-first" style="width: 158px;">Sun</th>
                                        <th class="fc-day-header fc-mon fc-widget-header" style="width: 158px;">Mon</th>
                                        <th class="fc-day-header fc-tue fc-widget-header" style="width: 158px;">Tue</th>
                                        <th class="fc-day-header fc-wed fc-widget-header" style="width: 158px;">Wed</th>
                                        <th class="fc-day-header fc-thu fc-widget-header" style="width: 158px;">Thu</th>
                                        <th class="fc-day-header fc-fri fc-widget-header" style="width: 158px;">Fri</th>
                                        <th class="fc-day-header fc-sat fc-widget-header fc-last" style="width: 158px;">Sat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($daysOfWeekMonth as $days)
                                        <tr class="fc-week fc-first">
                                            @foreach ($days as $id => $val)
                                                <td class="fc-day fc-sun fc-widget-content fc-other-month fc-first" onclick="getDayOfPool('{{$val==''?'':$val['date']}}');">
                                                    <div style="min-height: 80px;">
                                                        <div class="fc-day-number">{{ $val==''?'': $val['number']}}</div>
                                                        <div class="fc-event-inner">
                                                            @if($val!='')
                                                                @if($val['pool']!='')
                                                                    <div style="position: relative; height: 25px;">{{$val['pool']}} pools</div>
                                                                @endif
                                                            @endif                                                            
                                                        </div>
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="viewHistoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><h4>x</h4></button>
                     <h4 class="modal-title" id="myModalLabel"><input type="text" value="Wednesday, May 3, 2017"></input></h4>
                </div>
                <div class="modal-body">
                    <div class="panel">    
                        <div class="form-inline">
                            <div class="form-group">
                                <img class="circle-image avatar" src="">
                            </div>
                            <div class="form-group">
                                <label class="user-name">Teo, Nguyen Van</label>
                            </div>

                            <div class="form-group">
                                <label id="count_route">50 pools</label>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Street address</th>
                                    <th>City</th>
                                    <th>Zipcode</th>
                                    <th>Service completed</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i class="fa fa-book"></i> ECON 200</td>
                                    <td><strong class="text-primary"><i class="fa fa-calendar"></i> 15 now</strong> + all future</td>
                                    <td><i class="fa fa-check-circle text-success"> yes</i>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-book"></i> ACCT 210</td>
                                    <td><strong class="text-primary"><i class="fa fa-calendar"></i> 22 now</strong> + all future</td>
                                    <td><i class="fa fa-check-circle text-success"> yes</i>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-book"></i> MGMT 310</td>
                                    <td><strong class="text-primary"><i class="fa fa-calendar"></i> 30 now</strong> + all future</td>
                                    <td> <i class="fa fa-check-circle text-success"> yes</i>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="panel-footer text-center">You're unlocking: <strong>3 classes</strong> for <strong>300 points</strong>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
</div>
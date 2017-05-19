<div class="company-route-service">  
    <div class="sectionB1">
        <div align="right"><span id="lbl_history">History</span> <i class="glyphicon glyphicon-calendar btn-history-route"></i></div>
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
                                @if(count($value)>0)
                                    <h4>If you are not available to service pool on {{$key}}, check "Not available" box</h4>
                                @else                                    
                                    <h4>You currently have no routes list on {{$key}}</h4>
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
                            <li><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></li>
                            <li><h2>{{$currentMonthYear}}</h2></li>
                        </ul>
                    </div> 
                    <div class="fc-content" style="position: relative; min-height: 1px;">
                        <div class="fc-view fc-view-month fc-grid" style="position: relative; min-height: 1px;" unselectable="on">
                            
                            <table class="fc-border-separate" style="width:100%" cellspacing="0">
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
                                                <td class="fc-day fc-sun fc-widget-content fc-other-month fc-first" data-date="{{$val==''?'':$val['date']}}">
                                                    <div style="min-height: 80px;">
                                                        <div class="fc-day-number">{{ $val==''?'': $id}}</div>
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
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                     <h4 class="modal-title" id="myModalLabel"><i class="fa fa-fw fa-unlock"></i> Unlock Calendar</h4>

                </div>
                <div class="modal-body">
                    <p class="h3 text-center text-primary"><i class="fa fa-thumbs-up"></i> Woop!</p>
                    <p class="lead text-center">Here's what happens when you unlock your calendar:</p>
                    <hr>
                    <div class="row">
                        <div class="col-xs-1"> <i class="fa fa-fw fa-thumbs-up text-primary"></i>

                        </div>
                        <div class="col-xs-11">You'll instantly get access to all <strong class="text-primary">67 shared assignments</strong> on your calendar.</div>
                        <div class="col-xs-1"> <i class="fa fa-fw fa-thumbs-up text-primary"></i>

                        </div>
                        <div class="col-xs-11">You'll be <strong>notified</strong> whenever a shared assignment is <strong>updated or edited</strong> throughout the semester.</div>
                        <div class="col-xs-1"> <i class="fa fa-fw fa-thumbs-up text-primary"></i>

                        </div>
                        <div class="col-xs-11">You'll be able to <strong>share your own calendar assignments</strong> with your class, which means you can start making money instantly.</div>
                        <div class="col-xs-1"> <i class="fa fa-fw fa-thumbs-up text-primary"></i>

                        </div>
                        <div class="col-xs-11">You'll gain access to special features of mchp, such as <strong>calendar integration</strong> in your College Pulse and in each of your class's activity sections.</div>
                    </div>
                    <hr>
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <!-- Table -->
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Class Name</th>
                                    <th># of Assignments</th>
                                    <th>Unlock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i class="fa fa-book"></i> ECON 200</td>
                                    <td><strong class="text-primary"><i class="fa fa-calendar"></i> 15 now</strong> + all future</td>
                                    <td><i class="fa fa-check-circle text-success"> yes</i>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-book"></i> ACCT 210</td>
                                    <td><strong class="text-primary"><i class="fa fa-calendar"></i> 22 now</strong> + all future</td>
                                    <td><i class="fa fa-check-circle text-success"> yes</i>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-book"></i> MGMT 310</td>
                                    <td><strong class="text-primary"><i class="fa fa-calendar"></i> 30 now</strong> + all future</td>
                                    <td> <i class="fa fa-check-circle text-success"> yes</i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="panel-footer text-center">You're unlocking: <strong>3 classes</strong> for <strong>300 points</strong>
                        </div>
                    </div>
                    <!-- Begin Carousel -- <div id="carousel-example-generic" class="carousel slide">
                  
  <!-- Indicators 
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>-->
                    <!-- Wrapper for slides -- <div class="carousel-inner">
    <div class="item ">
        <div class="custom-content">
      <div class="media">
  <a class="pull-left" href="#">
    <img class="media-object" src="https://s3-us-west-2.amazonaws.com/mchpstatic/calendar.svg" alt="...">
  </a>
  <div class="media-body">
    <h4 class="media-heading">Poop Assignments</h4>
    <p>Any assignment shared by any of your classmates will be visible to you, and you'll get the option to add it to your own calendar. This includes any assignment that is updated or edited throughout the semester.</p>
  </div>
</div>
            </div>
      
    </div>
    
  </div>
                  
                  
                  <div class="carousel-inner">
    <div class="item ">
        <div class="custom-content">
      <div class="media">
  <a class="pull-left" href="#">
    <img class="media-object" src="https://s3-us-west-2.amazonaws.com/mchpstatic/calendar.svg" alt="...">
  </a>
  <div class="media-body">
    <h4 class="media-heading">Poop Assignments</h4>
    <p>Any assignment shared by any of your classmates will be visible to you, and you'll get the option to add it to your own calendar. This includes any assignment that is updated or edited throughout the semester.</p>
  </div>
</div>
            </div>
      
    </div>
    
  </div>
                  
                  
  <div class="carousel-inner">
    <div class="item active">
        <div class="custom-content">
      <div class="media">
  <a class="pull-left" href="#">
    <img class="media-object" src="https://s3-us-west-2.amazonaws.com/mchpstatic/calendar.svg" alt="...">
  </a>
  <div class="media-body">
    <h4 class="media-heading">Shared Assignments</h4>
    <p>Any assignment shared by any of your classmates will be visible to you, and you'll get the option to add it to your own calendar. This includes any assignment that is updated or edited throughout the semester.</p>
  </div>
</div>
            </div>
      
    </div>
    
  </div>
      
      


  <!-- Controls --
    <p class="pull-right">
        <a class="" href="#carousel-example-generic" data-slide="prev"><i class="fa fa-hand-o-left fa-lg"></i></a> 
        <a class="" href="#carousel-example-generic" data-slide="next"><i class="fa fa-hand-o-right fa-lg"></i></a> 
        
    </p>    
</div>
                      
              <!-- End Carousel --></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Unlock!</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
</div>
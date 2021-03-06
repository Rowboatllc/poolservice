let directionsDisplay;
let directionsService = new google.maps.DirectionsService();
let map;

$(document).ready(function(){
    $('.company-route-service i.btn-history-route').on('click',function(){
        if($(this).hasClass('glyphicon-calendar'))
        {
            $('.company-route-service div.route-calendar').removeClass('hidden');
            $('.company-route-service div.route-tab-container').addClass('hidden');
            $(this).removeClass('glyphicon-calendar');
            $(this).addClass('glyphicon-th-list');
            $('#lbl_history').text('Daily View');
        }else{
            $('.company-route-service div.route-calendar').addClass('hidden');
            $('.company-route-service div.route-tab-container').removeClass('hidden');
            $(this).removeClass('glyphicon-th-list');
            $(this).addClass('glyphicon-calendar');
            $('#lbl_history').text('History');
        }  
    });
    
    $(".sectionB1 div.route-tab-menu>div.list-group-route>a").click(function(e) {
        e.preventDefault();
        let pre_day=$.trim($(this).siblings('a.active').text());
        $(this).siblings('a.active').removeClass("active");        
        $(this).addClass("active");
        let index = $(this).index();
        $("div.route-tab>div.route-tab-content").removeClass("active");
        $("div.route-tab>div.route-tab-content").eq(index).addClass("active");
        $("div.title-route-map label").text($(this).text());
        reloadTableNotAssign(pre_day,$.trim($(this).text()));
        reloadMap($(this).text());         
    });

    $('.company-route-service select.pool-service-technician-list').on('change', function(e) {        
        let date=this.id;
        $.ajax({ 
            headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "load-pool-owner",
            method: "GET",
            data: { id : this.value,date:date},
            success: function (data) {
                if(data.success===true)
                {
                    $('#count_route').text(data.message.length + " pools");
                    $('.table-route-'+date+' tbody tr').remove();
                    let table=$('.table-route-'+date+' tbody');
                    let m=0;
                    jQuery.each(data.message, function(index, item) {
                        let n=parseInt(index) +1;
                        let row="<tr>";
                        row+="<td><input type='checkbox' checked></input></td>";
                        row+="<td>"+ n +"</td>";
                        row+="<td>"+item.address+"</td>";
                        row+="<td>"+item.city+"</td>";
                        row+="<td>"+item.zipcode+"</td>";
                        if(item.status=='billing_error' || item.status=='billing_success')
                        {
                            row+="<td ><i class='fa fa-check-square icon-success' aria-hidden='true'></i></td>";
                        }
                        else
                        {
                            row+="<td ><i class='fa fa-check-square' aria-hidden='true'></i></td>";
                        }
                        
                        row+="</tr>";
                        table.append(row);
                        m=m+1;
                    });

                    if(m>1)
                    {
                        $('div.total-route-date strong').first().text(m + ' routes');
                    }else
                    {
                        $('div.total-route-date strong').first().text(m + ' route');
                    }   

                    console.log(data.message);                 
                }
            },
            error: function (ajaxContext) {
                console.log(ajaxContext.responseText);
            }
        });	
    })

    $('.company-route-service input.chk-not-available').on('change',function(e){
        let date=$(this).attr('date');
        let selected = $('.company-route-service select.pool-service-technician-list-'+date+'').find(":selected").val();
        if($(this).prop('checked')){   
            $.ajax({ 
                headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "change-task-not-available",
                method: "GET",
                data: {id:selected,date:date},
                success: function (data) {
                    if(data.success===true)
                    {
                        var rowAssign = $('.company-route-service table.table-route-'+date+' tbody tr').length;
                        var rowNotAssign = $('.company-route-service table.table-route-not-assign-'+date+' tbody tr').length;

                        $('.company-route-service .table-route-'+date+' tbody tr.tr-billing-error input[type="checkbox"]').prop('checked', false);
                        var n=0;
                        $('.company-route-service table.table-route-'+date+' tbody tr.tr-billing-error').each(function() {
                            n++;
                            $(this).find('td.chk-service-status').remove();
                            $(this).find('td.number-to-route').text(parseInt(rowNotAssign)+n);
                            $('.company-route-service table.table-route-not-assign-'+date).find('tbody').append($(this));
                        });

                        // change count of footer table
                        $('.company-route-service div.total-route-date-'+date+' strong').first().text((parseInt(rowAssign)-n) + " routes ");
                        $('.company-route-service div.total-route-date-not-assign-'+date).find('strong').first().text((parseInt(rowNotAssign)+n)+ " routes ");     

                        //change count of header table
                        $('.company-route-service label.count-route-'+date +'').text((parseInt(rowAssign)-n) + " pools ");
                        $('.company-route-service label.count-route-not-assign-'+date).text((parseInt(rowNotAssign)+n) + " pools ");
                        
                        //remove schedule from table assign
                        $('.company-route-service table.table-route-'+date+' tbody tr.tr-billing-error').remove();
                    }
                },
                error: function (ajaxContext) {
                    console.log(ajaxContext.responseText);
                }
            });	           
        }     
    });

    $('i.btn-load-monthly-view').bind('click',function(){
        let type=1;//last-month
        if($(this).hasClass('next-month')){
            type=2;//next month
        }
        let date=$('#current-month-year').text();
        $.ajax({ 
            headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "load-last-month-view",
            method: "GET",
            data: {date:date,type:type},
            success: function (data) {
                if(data.success===true)
                {
                    $('.company-route-service #current-month-year').text(data.message['date']);
                    $('.company-route-service #table-calendar-history tbody tr').remove();
                    let table=$('.company-route-service #table-calendar-history tbody');
                    $.each(data.message['schedule'], function (i, dates) {
                        let row="<tr>";
                        $.each(dates, function (id, val) {
                            debugger;
                            if(val==""){
                                row+="<td class='fc-day fc-sun fc-widget-content fc-other-month fc-first' onclick='getDayOfPool();'>";
                            }else{
                                row+="<td class='fc-day fc-sun fc-widget-content fc-other-month fc-first' onclick='getDayOfPool(`" + val['date']+ "`);'>";
                            }
                            
                            row+="<div style='min-height: 80px;'>";    
                            if(val==""){
                                row+="<div class='fc-day-number'></div>";
                            }   else{
                                row+="<div class='fc-day-number'>"+ val['number'] +"</div>";
                            }
                            
                            row+="<div class='fc-event-inner'>";
                            if(val!="" && val['pool']!="")
                            {
                                row+="<div style='position: relative; height: 25px;'>"+val['pool'] +" pools</div>";
                            }else{
                                row+="<div style='position: relative; height: 25px;'></div>";
                            }                   
                                                                                   
                            row+="</div>";
                            row+="</div>";
                            row+="</td>";
                        });                        
                        row+="</tr>";
                        debugger;
                        table.append(row);
                    });     
                }
            },
            error: function (ajaxContext) {
                console.log(ajaxContext.responseText);
            }
        });	
    });
    
});


function reloadTableNotAssign(pre_day,to_day)
{
    if(pre_day=='' || to_day==''||pre_day==undefined || to_day==undefined) return;

    $('.company-route-service table.table-route-not-assign-'+to_day+' tbody').empty();
    $('.company-route-service table.table-route-not-assign-'+to_day+' tbody').append($('.company-route-service table.table-route-not-assign-'+pre_day+' tbody tr'));   
}

function getDayOfPool(element) {
    // alert(element);
    $('.company-route-service #viewHistoryModal').modal();
    // alert("row" + element.parentNode.parentNode.rowIndex + 
    // " - column" + element.parentNode.cellIndex);
}

function reloadMap(route_date) 
{    
    directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers:true});
    if ($('#route-map').length > 0) {
        let user=new Object();
        let user_nest=new Object();
        user_nest.address=$('.user-name-'+ $.trim(route_date)).text();
        user_nest.lat=$('.user-lat-'+ $.trim(route_date)).text();
        user_nest.lng=$('.user-lng-'+ $.trim(route_date)).text();
        user.title=$('.user-address-'+ $.trim(route_date)).text();
        user.address=user_nest;
        let locations=[]; 
        locations.push(user); 
        let class_tr=".table.table-route-"+ $.trim(route_date)+" > tbody  > tr";
        $(class_tr).each(function() {
            let name='';
            var myObject = new Object();
            var obj = new Object();
            $(this).find('td').each (function() {
                
                if($(this).hasClass("address-to-route"))
                {
                    obj.address=$(this).text();
                }
                if($(this).hasClass("lat-to-route"))
                {
                    obj.lat=$(this).text();
                }
                if($(this).hasClass("lng-to-route"))
                {
                    obj.lng=$(this).text();
                }

                if($(this).hasClass("fullname-to-route"))
                {
                    name=$(this).text();
                }
            });  

            myObject.title=name;
            myObject.address=obj;
            locations.push(myObject);
        });

        map = new google.maps.Map(document.getElementById('route-map'), {
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: true,
            zoom: 10
        });

        let flightPlanCoordinates = [];
        if(locations.length<2){
            for(i=0; i<flightPlanCoordinates.length; i++){
                flightPlanCoordinates[i].setMap(null);
            }      

            $('#directions_panel').empty();
        } else{            
            directionsDisplay.setMap(map);            
            let infowindow = new google.maps.InfoWindow();            
            let bounds = new google.maps.LatLngBounds();
            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i].address.lat, locations[i].address.lng),
                    map: map
                });
                flightPlanCoordinates.push(marker.getPosition());
                bounds.extend(marker.position);

                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow.setContent(locations[i]['title']);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }

            map.fitBounds(bounds);
            // directions service
            let start = flightPlanCoordinates[0];
            let end = flightPlanCoordinates[flightPlanCoordinates.length - 1];
            let waypts = [];
            for (let i = 1; i < flightPlanCoordinates.length - 1; i++) {
                waypts.push({
                    location: flightPlanCoordinates[i],
                    stopover: true
                });
            }
            calcRoute(start, end, waypts);
        }
    }
}

function calcRoute(start, end, waypts) 
{
    let request = {
        origin: start,
        destination: end,
        waypoints: waypts,
        optimizeWaypoints: true,
        travelMode: google.maps.TravelMode.DRIVING
    };
    directionsService.route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
            let route = response.routes[0];
            let summaryPanel = document.getElementById('directions_panel');
            summaryPanel.innerHTML = '';
            // For each route, display summary information.
            for (let i = 0; i < route.legs.length; i++) {
                let routeSegment = i + 1;
                summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment + '</b><br>';
                summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
                summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
                summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
            }
        }
    });
}

function initMap() 
{
    directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers:true});
    if ($('#route-map').length > 0) {
        let date=$('div.list-group-route a.active').text();        
        date=$.trim(date);
        let user=new Object();
        let user_nest=new Object();
        user_nest.address=$('.user-name-'+ date).text();
        user_nest.lat=$('.user-lat-'+ date).text();
        user_nest.lng=$('.user-lng-'+ date).text();
        user.title=$('.user-address-'+ date).text();
        user.address=user_nest;
        let locations=[]; 
        locations.push(user);    
        $('.table-active > tbody  > tr').each(function() {    
            let name='';
            var myObject = new Object();
            var obj = new Object();
            $(this).find('td').each (function() {
                
                if($(this).hasClass("address-to-route"))
                {
                    obj.address=$(this).text();
                }
                if($(this).hasClass("lat-to-route"))
                {
                    obj.lat=$(this).text();
                }
                if($(this).hasClass("lng-to-route"))
                {
                    obj.lng=$(this).text();
                }

                if($(this).hasClass("fullname-to-route"))
                {
                    name=$(this).text();
                }
            });  

            myObject.title=name;
            myObject.address=obj;
            locations.push(myObject);
        });

        if(locations.length<2) return;
        
        map = new google.maps.Map(document.getElementById('route-map'), {
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: true,
            zoom: 10
        });
        directionsDisplay.setMap(map);
        
        let infowindow = new google.maps.InfoWindow();
        let flightPlanCoordinates = [];
        let bounds = new google.maps.LatLngBounds();

        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i].address.lat, locations[i].address.lng),
                map: map
            });
            flightPlanCoordinates.push(marker.getPosition());
            bounds.extend(marker.position);

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent(locations[i]['title']);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }

        map.fitBounds(bounds);
        // directions service
        let start = flightPlanCoordinates[0];
        let end = flightPlanCoordinates[flightPlanCoordinates.length - 1];
        let waypts = [];
        for (let i = 1; i < flightPlanCoordinates.length - 1; i++) {
            waypts.push({
                location: flightPlanCoordinates[i],
                stopover: true
            });
        }
        calcRoute(start, end, waypts);
    }
}


google.maps.event.addDomListener(window, 'load', initMap);
let directionsDisplay;
let directionsService = new google.maps.DirectionsService();
let map;

$(document).ready(function(){
    
    $(".sectionB1 div.route-tab-menu>div.list-group-route>a").click(function(e) {
        e.preventDefault();        
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        let index = $(this).index();
        $("div.route-tab>div.route-tab-content").removeClass("active");
        $("div.route-tab>div.route-tab-content").eq(index).addClass("active");
        $("div.title-route-map").text($(this).text() + " Route Map");
        reloadMap($(this).text());         
    });

    $('.company-route-service select').on('change', function(e) {
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

                    jQuery.each(data.message, function(index, item) {
                        let n=parseInt(index) +1;
                        let row="<tr>";
                        row+="<td><input type='checkbox' checked></input></td>";
                        row+="<td>"+ n +"</td>";
                        row+="<td>"+item.address+"</td>";
                        row+="<td>"+item.city+"</td>";
                        row+="<td>"+item.zipcode+"</td>";
                        row+="</tr>";

                        table.append(row);
                    });
                }
            },
            error: function (ajaxContext) {
                console.log(ajaxContext.responseText);
            }
        });	
    })

    $('.chk-not-available').on('change',function(e){
        let date=$(this).attr('date');
        if($(this).prop('checked')){            
            $('.avatar-'+date+'').addClass('hidden');
            $('.name-'+date+'').addClass('hidden');
            $('.not-asign-'+date+'').removeClass('hidden');
            $('.table-route-'+date+' input[type="checkbox"]').prop('checked', false);
        }else{
            $('.avatar-'+date+'').removeClass('hidden');
            $('.name-'+date+'').removeClass('hidden');
            $('.not-asign-'+date+'').addClass('hidden');
            $('.table-route-'+date+' input[type="checkbox"]').prop('checked', true);
        }        
    });
});

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
        console.log(user);
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
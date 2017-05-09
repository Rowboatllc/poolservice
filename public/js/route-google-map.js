// function initMap() {
//     var map = new google.maps.Map(document.getElementById('route-map'), {
//         zoom: 3,
//         center: {lat: 0, lng: -180},
//         mapTypeId: 'terrain'
//     });

//     var flightPlanCoordinates = [
//         {lat: 37.772, lng: -122.214},
//         {lat: 21.291, lng: -157.821},
//         {lat: -18.142, lng: 178.431},
//         {lat: -27.467, lng: 153.027}
//     ];
//     var flightPath = new google.maps.Polyline({
//         path: flightPlanCoordinates,
//         geodesic: true,
//         strokeColor: '#FF0000',
//         strokeOpacity: 1.0,
//         strokeWeight: 2
//     });

//     flightPath.setMap(map);
// }

// $(document).ready(function () {
//     var map;
//     var elevator;
//     var myOptions = {
//         zoom: 1,
//         center: new google.maps.LatLng(0, 0),
//         mapTypeId: 'terrain'
//     };
//     map = new google.maps.Map($('#route-map'), myOptions);

//     var addresses = ['Norway', 'Africa', 'Asia','North America','South America'];

//     for (var x = 0; x < addresses.length; x++) {
//         $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+addresses[x]+'&sensor=false', null, function (data) {
//             var p = data.results[0].geometry.location
//             var latlng = new google.maps.LatLng(p.lat, p.lng);
//             new google.maps.Marker({
//                 position: latlng,
//                 map: map
//             });

//         });
//     }

// }); 

function initMap() {
    // var uluru = {lat: -25.363, lng: 131.044};
    // var map = new google.maps.Map(document.getElementById('route-map'), {
    //     zoom: 4,
    //     center: uluru
    // });
    // var marker = new google.maps.Marker({
    //     position: uluru,
    //     map: map
    // });
    var myOptions = {
    mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("route-map"), myOptions);
        
    // init directions service
    var dirService = new google.maps.DirectionsService();
    var dirRenderer = new google.maps.DirectionsRenderer({suppressMarkers: true});
    dirRenderer.setMap(map);

    // highlight a street
    var request = {
    origin: "48.1252,11.5407",
    destination: "48.13376,11.5535",
    //waypoints: [{location:"48.12449,11.5536"}, {location:"48.12515,11.5569"}],
    travelMode: google.maps.TravelMode.DRIVING
    };
    dirService.route(request, function(result, status) {
    if (status == google.maps.DirectionsStatus.OK) {
        dirRenderer.setDirections(result);
    }
    });
}
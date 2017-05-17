$(document).ready(function () {
	getLocation(1);
});
let gmarkers = []; let map; let origin = ""; let geolocation; let directionsDisplay;

let getCurrentPosition = function() {
  let deferred = $.Deferred();

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(deferred.resolve, deferred.reject);
  } else {
    deferred.reject({
      error: 'browser doesn\'t support geolocation'
    });
  }

  return deferred.promise();
};

function getLocation() {
	var userPositionPromise = getCurrentPosition();
	userPositionPromise
	.then(function(data) {
		showPosition(data);
	})
	.fail(function(error) {
		alert("Geolocation is not supported by this browser.");
	});
}
function showPosition(position) {

	let latitude = position.coords.latitude;
	let longitude = position.coords.longitude;

	// defaul arizona 
	latitude = 33.451658; longitude = -112.064610;

	origin += latitude + "," + longitude;

    let elevator;

	let myOptions = {
		zoom: 12,
		center: new google.maps.LatLng(latitude, longitude),
		mapTypeId: 'roadmap'
	};
	map = new google.maps.Map($('#map_poolservices')[0], myOptions);

	let latlng = new google.maps.LatLng(latitude, longitude);
	geolocation = new google.maps.Marker({
		position: latlng,
		map: map,
		title: 'You are here!',
		icon: 'images/blue-dot.png'
	});

	setMarker(0);
	
}

function setMarker(weekday){
	gmarkers = [];
	let addresses = schedules[weekday].value;
	let checkin = true;
	for (var x = 0; x < addresses.length; x++) {
		var latlng = new google.maps.LatLng(addresses[x].lat, addresses[x].lng);
		let marker = new google.maps.Marker({
			position: latlng,
			map: map,
			title: addresses[x].fullname
		});
		gmarkers.push(marker);
		if(addresses[x].status=="checkin" && checkin){
			let destination = addresses[x].lat + "," + addresses[x].lng;
			removeDirectionsDisplay();
			directionsMap(destination);
			checkin = false;
		}
	}
}


function directionsMap(destination) {
	if(!origin||origin==""){
		origin = "0,0";
	}
	if(!destination||destination==""){
		destination = "0,0";
	}
	var markerArray=[];

	// Instantiate a directions service.
	var directionsService=new google.maps.DirectionsService;

	// Create a renderer for directions and bind it to the map.
	directionsDisplay=new google.maps.DirectionsRenderer( {
		map: map
	}
	);
	// Instantiate an info window to hold step text.
	var stepDisplay = new google.maps.InfoWindow;
	// Display the route between the initial start and end selections.
	calculateAndDisplayRoute(
	    directionsDisplay, directionsService, map, origin, destination);
	// Listen to change events from the start and end lists.
	var onChangeHandler = function() {
	  calculateAndDisplayRoute(
	      directionsDisplay, directionsService, map, origin, destination);
	};
}

function calculateAndDisplayRoute(directionsDisplay, directionsService, map, origin, destination) {
	// WALKING directions.
	directionsService.route( {
		origin: origin, destination: destination, travelMode: 'DRIVING'
	}
	, function(response, status) {
		// Route the directions and pass the response to a function to create
		// markers for each step.
		if (status==='OK') {
			document.getElementById('warnings-panel').innerHTML='<b>' + response.routes[0].warnings + '</b>';
			directionsDisplay.setDirections(response);
		}
		else {
			window.alert('Directions request failed due to ' + status);
		}
	}
	);
}

function removeMarkers(){
    for(i=0; i<gmarkers.length; i++){
        gmarkers[i].setMap(null);
    }
}

function removeDirectionsDisplay(){
    if(directionsDisplay != null) {
		directionsDisplay.setMap(null);
		directionsDisplay = null;
	}
}
$(document).ready(function () {
	getLocation(1);
});
let gmarkers = [];
let map;
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

    let elevator;

	let myOptions = {
		zoom: 12,
		center: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
		mapTypeId: 'roadmap'
	};
	map = new google.maps.Map($('#map_poolservices')[0], myOptions);

	var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
	new google.maps.Marker({
		position: latlng,
		map: map,
		title: 'You are here!',
		icon: 'images/blue-dot.png'
	});

	setMarker(0);
	
}

function setMarker(weekday){
	
	let addresses = schedules[weekday].value;

	for (var x = 0; x < addresses.length; x++) {
		var latlng = new google.maps.LatLng(addresses[x].lat, addresses[x].lng);
		let marker = new google.maps.Marker({
			position: latlng,
			map: map,
			title: addresses[x].fullname
		});
		gmarkers.push(marker);
	}
}


function initMap() {
	var markerArray=[];
	// Instantiate a directions service.
	var directionsService=new google.maps.DirectionsService;

	// Create a renderer for directions and bind it to the map.
	var directionsDisplay=new google.maps.DirectionsRenderer( {
		map: map
	}
	);
	// Instantiate an info window to hold step text.
	var stepDisplay = new google.maps.InfoWindow;
	// Display the route between the initial start and end selections.
	calculateAndDisplayRoute(
	    directionsDisplay, directionsService, markerArray, stepDisplay, map);
	// Listen to change events from the start and end lists.
	var onChangeHandler = function() {
	  calculateAndDisplayRoute(
	      directionsDisplay, directionsService, markerArray, stepDisplay, map);
	};
}

function calculateAndDisplayRoute(directionsDisplay, directionsService, markerArray, stepDisplay, map) {
	// First, remove any existing markers from the map.
	for (var i=0;
	i < markerArray.length;
	i++) {
		markerArray[i].setMap(null);
	}
	// Retrieve the start and end locations and create a DirectionsRequest using
	// WALKING directions.
	directionsService.route( {
		origin: "Tonto National Forest, Hwy 188 Sign 259", destination: "300 E Sundance Ln , Tonto Basin", travelMode: 'DRIVING'
	}
	, function(response, status) {
		// Route the directions and pass the response to a function to create
		// markers for each step.
		if (status==='OK') {
			document.getElementById('warnings-panel').innerHTML='<b>' + response.routes[0].warnings + '</b>';
			directionsDisplay.setDirections(response);
			showSteps(response, markerArray, stepDisplay, map);
		}
		else {
			window.alert('Directions request failed due to ' + status);
		}
	}
	);
}

function showSteps(directionResult, markerArray, stepDisplay, map) {
	// For each step, place a marker, and add the text to the marker's infowindow.
	// Also attach the marker to an array so we can keep track of it and remove it
	// when calculating new routes.
	var myRoute=directionResult.routes[0].legs[0];
	for (var i=0;
	i < myRoute.steps.length;
	i++) {
		var marker=markerArray[i]=markerArray[i] || new google.maps.Marker;
		marker.setMap(map);
		marker.setPosition(myRoute.steps[i].start_location);
		attachInstructionText( stepDisplay, marker, myRoute.steps[i].instructions, map);
	}
}

function attachInstructionText(stepDisplay, marker, text, map) {
	google.maps.event.addListener(marker, 'click', function() {
		// Open an info window when the marker is clicked on, containing the text
		// of the step.
		stepDisplay.setContent(text);
		stepDisplay.open(map, marker);
	}
	);
}

function removeMarkers(){
    for(i=0; i<gmarkers.length; i++){
        gmarkers[i].setMap(null);
    }
}
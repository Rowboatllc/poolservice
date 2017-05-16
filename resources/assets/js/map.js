$(document).ready(function () {
    var map;
    var elevator;
	var addresses = ['3158 Adams Forge Suite 044', '478 Thalia Cove Suite 176', '1962 Kaylee Vista Suite 232'];

	getLocation();
	$.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+addresses[0]+'&sensor=false', null, function (data) {
		var p = data.results[0].geometry.location
		var latlng = new google.maps.LatLng(p.lat, p.lng);
		var myOptions = {
			zoom: 6,
			center: new google.maps.LatLng(p.lat, p.lng),
			mapTypeId: 'terrain'
		};
		map = new google.maps.Map($('#map_poolservices')[0], myOptions);

		for (var x = 0; x < addresses.length; x++) {
        	$.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+addresses[x]+'&sensor=false', null, function (data) {
				var p = data.results[0].geometry.location
				var latlng = new google.maps.LatLng(p.lat, p.lng);
				new google.maps.Marker({
					position: latlng,
					map: map
				});

			});
		}

	});

});

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        console.log("Geolocation is not supported by this browser.");
    }
}
function showPosition(position) {
	console.log(position.coords.latitude, position.coords.longitude);
}

// function initMap() {
// 	var markerArray=[];
// 	// Instantiate a directions service.
// 	var directionsService=new google.maps.DirectionsService;
// 	// Create a map and center it on Manhattan.
// 	var map=new google.maps.Map(document.getElementById('map'), {
// 		zoom: 6, center: {
// 			lat: 40.771, lng: -73.974
// 		}
// 	}
// 	);
// 	// Create a renderer for directions and bind it to the map.
// 	var directionsDisplay=new google.maps.DirectionsRenderer( {
// 		map: map
// 	}
// 	);
// 	// Instantiate an info window to hold step text.
// 	var stepDisplay = new google.maps.InfoWindow;
// 	// Display the route between the initial start and end selections.
// 	calculateAndDisplayRoute(
// 	    directionsDisplay, directionsService, markerArray, stepDisplay, map);
// 	// Listen to change events from the start and end lists.
// 	var onChangeHandler = function() {
// 	  calculateAndDisplayRoute(
// 	      directionsDisplay, directionsService, markerArray, stepDisplay, map);
// 	};
// }

// function calculateAndDisplayRoute(directionsDisplay, directionsService, markerArray, stepDisplay, map) {
// 	// First, remove any existing markers from the map.
// 	for (var i=0;
// 	i < markerArray.length;
// 	i++) {
// 		markerArray[i].setMap(null);
// 	}
// 	// Retrieve the start and end locations and create a DirectionsRequest using
// 	// WALKING directions.
// 	directionsService.route( {
// 		origin: "Tonto National Forest, Hwy 188 Sign 259", destination: "300 E Sundance Ln , Tonto Basin", travelMode: 'DRIVING'
// 	}
// 	, function(response, status) {
// 		// Route the directions and pass the response to a function to create
// 		// markers for each step.
// 		if (status==='OK') {
// 			document.getElementById('warnings-panel').innerHTML='<b>' + response.routes[0].warnings + '</b>';
// 			directionsDisplay.setDirections(response);
// 			showSteps(response, markerArray, stepDisplay, map);
// 		}
// 		else {
// 			window.alert('Directions request failed due to ' + status);
// 		}
// 	}
// 	);
// }

// function showSteps(directionResult, markerArray, stepDisplay, map) {
// 	// For each step, place a marker, and add the text to the marker's infowindow.
// 	// Also attach the marker to an array so we can keep track of it and remove it
// 	// when calculating new routes.
// 	var myRoute=directionResult.routes[0].legs[0];
// 	for (var i=0;
// 	i < myRoute.steps.length;
// 	i++) {
// 		var marker=markerArray[i]=markerArray[i] || new google.maps.Marker;
// 		marker.setMap(map);
// 		marker.setPosition(myRoute.steps[i].start_location);
// 		attachInstructionText( stepDisplay, marker, myRoute.steps[i].instructions, map);
// 	}
// }

// function attachInstructionText(stepDisplay, marker, text, map) {
// 	google.maps.event.addListener(marker, 'click', function() {
// 		// Open an info window when the marker is clicked on, containing the text
// 		// of the step.
// 		stepDisplay.setContent(text);
// 		stepDisplay.open(map, marker);
// 	}
// 	);
// }

    // function initMap() {
    //     var markerArray = [];

    //     // Instantiate a directions service.
    //     var directionsService = new google.maps.DirectionsService;

    //     // Create a map and center it on Manhattan.
    //     var map = new google.maps.Map(document.getElementById('map'), {
    //       zoom: 20,
    //       center: {lat: 40.771, lng: -73.974}
    //     });

    //     // Create a renderer for directions and bind it to the map.
    //     var directionsDisplay = new google.maps.DirectionsRenderer({map: map});

    //     // Instantiate an info window to hold step text.
    //     var stepDisplay = new google.maps.InfoWindow;

    //     // Display the route between the initial start and end selections.
    //     calculateAndDisplayRoute(
    //         directionsDisplay, directionsService, markerArray, stepDisplay, map);
    //     // Listen to change events from the start and end lists.
    //     var onChangeHandler = function() {
    //       calculateAndDisplayRoute(
    //           directionsDisplay, directionsService, markerArray, stepDisplay, map);
    //     };
    //   }

    //   function calculateAndDisplayRoute(directionsDisplay, directionsService,
    //       markerArray, stepDisplay, map) {
    //     // First, remove any existing markers from the map.
    //     for (var i = 0; i < markerArray.length; i++) {
    //       markerArray[i].setMap(null);
    //     }

    //     // Retrieve the start and end locations and create a DirectionsRequest using
    //     // WALKING directions.
    //     directionsService.route({
    //       origin: "Tonto National Forest, Hwy 188 Sign 259",
    //       destination: "300 E Sundance Ln , Tonto Basin",
    //       travelMode: 'DRIVING'
    //     }, function(response, status) {
    //       // Route the directions and pass the response to a function to create
    //       // markers for each step.
    //       if (status === 'OK') {
    //         document.getElementById('warnings-panel').innerHTML =
    //             '<b>' + response.routes[0].warnings + '</b>';
    //         directionsDisplay.setDirections(response);
    //         showSteps(response, markerArray, stepDisplay, map);
    //       } else {
    //         window.alert('Directions request failed due to ' + status);
    //       }
    //     });
    //   }

    //   function showSteps(directionResult, markerArray, stepDisplay, map) {
    //     // For each step, place a marker, and add the text to the marker's infowindow.
    //     // Also attach the marker to an array so we can keep track of it and remove it
    //     // when calculating new routes.
    //     var myRoute = directionResult.routes[0].legs[0];
    //     for (var i = 0; i < myRoute.steps.length; i++) {
    //       var marker = markerArray[i] = markerArray[i] || new google.maps.Marker;
    //       marker.setMap(map);
    //       marker.setPosition(myRoute.steps[i].start_location);
    //       attachInstructionText(
    //           stepDisplay, marker, myRoute.steps[i].instructions, map);
    //     }
    //   }

    //   function attachInstructionText(stepDisplay, marker, text, map) {
    //     google.maps.event.addListener(marker, 'click', function() {
    //       // Open an info window when the marker is clicked on, containing the text
    //       // of the step.
    //       stepDisplay.setContent(text);
    //       stepDisplay.open(map, marker);
    //     });
    //   }

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 6
        });
        infoWindow = new google.maps.InfoWindow;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            infoWindow.open(map);
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }
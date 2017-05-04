function initMap() {
    document.getElementById('route-map').style.display="block";
    var map = new google.maps.Map(document.getElementById('route-map'), {
        center: { lat: 34.397, lng: 150.644 },
        scrollwheel: false,
        zoom: 20
    });
}

$(document).ready(function(){
    
});
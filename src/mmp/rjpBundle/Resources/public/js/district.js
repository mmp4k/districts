$(function() {
    function initialize() {                
        var mapOptions = {
            zoom: 13,
            center: new google.maps.LatLng(50.264892, 19.023782),          
        };

        var map = new google.maps.Map(document.getElementById('map'), mapOptions);

        var ctaLayer = new google.maps.KmlLayer({
            url: $('*[data-kml]').attr('data-kml'),
        });
        ctaLayer.setMap(map);

        google.maps.event.addListener(ctaLayer, 'status_changed', function () {
            google.maps.event.addListenerOnce(map, 'zoom_changed', function () {
                map.setZoom(14);
                var bounds = ctaLayer.getDefaultViewport();
                map.setCenter(bounds.getCenter());
            });
        });        
    }
    google.maps.event.addDomListener(window, 'load', initialize);    
});
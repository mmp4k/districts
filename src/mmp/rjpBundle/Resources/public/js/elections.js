$(function() {
    function loadCharts() {
        var keyElection = $('.tab-election.active').attr('id');
        var key = $('.tab-election.active .tab-table-election.active').attr('id');
        if(key.indexOf('obwody') > 0) {        
            initMap(key);
            return;
        }    
        obj = chartsDrawFunctions[key];    
        obj ? obj(keyElection) : null;
    }

    function loadMaps() {
        var par = $('.tab-election.active .tab-table-election.active');

        var colors = ['#f1c40f', '#e67e22', '#e74c3c', '#2980b9', '#8e44ad'];

        var map = new google.maps.Map($('.map-vote', par)[0], {
            zoom: 12,
            center: new google.maps.LatLng(50.254892, 19.023782),
            disableDefaultUI: false,
            zoomControl: true,
        });            

        var ctaLayer = new google.maps.KmlLayer({
            url: $('*[data-kml]', par).attr('data-kml'),
        });
        ctaLayer.setMap(map);

        google.maps.event.addListener(ctaLayer, 'status_changed', function () {
            google.maps.event.addListenerOnce(map, 'zoom_changed', function () {
                map.setZoom(14);
                var bounds = ctaLayer.getDefaultViewport();
                map.setCenter(bounds.getCenter());
                ctaLayer.setMap(null);
            });
        });

        $('*[data-vote-polygon]', par).each(function(i) {
            // point
            var point = $(this).attr('data-vote-point').split(',');
            var marker = new google.maps.Marker({  
                position: new google.maps.LatLng(point[0], point[1]),   
                map: map,  
                icon: $('img', $(this).next()).attr('src')
            });   

            // polygon
            var polygonString = $(this).attr('data-vote-polygon');
            var polygonArray = polygonString.split(' ');
            

            var polygonPoints = [];

            for(k in polygonArray) {
                var polygonPoint = polygonArray[k].split(',');
                polygonPoints.push(new google.maps.LatLng(polygonPoint[1], polygonPoint[0]));
            }
            polygon = new google.maps.Polygon({
                                                paths: polygonPoints,
                                                strokeOpacity: 0.8,
                                                strokeWeight: 0.5,                                                
                                                fillOpacity: 0.35,
                                                fillColor: colors[i],
                                                strokeColor: colors[i]                                                
                                            });            
            polygon.setMap(map);
            
        })
    }
    loadMaps();

    $('a[role=tab]').on('shown.bs.tab', function (e) {
        loadCharts();
        loadMaps();
    })
});
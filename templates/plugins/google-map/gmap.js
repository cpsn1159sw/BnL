window.marker = null;

function initialize() {
    var map;

    var hcmc = new google.maps.LatLng(10.78947454611481, 106.70072973675899);

    var style = [
        {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [
                { "color": "#ffffff" } // Màu của đường
            ]
        }, {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [
                { "color": "#e5e5e5" } // Màu của các điểm quan trọng (POI)
            ]
        }, {
            "featureType": "landscape",
            "elementType": "geometry",
            "stylers": [
                { "color": "#f2f2f2" } // Màu của các khu vực cảnh quan
            ]
        }, {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [
                { "color": "#a2daf2" } // Màu của mặt nước
            ]
        }, {
            "featureType": "transit",
            "elementType": "all",
            "stylers": [
                { "visibility": "off" } // Tắt hiển thị các phương tiện giao thông công cộng
            ]
        }
    ];
    
    var mapOptions = {
        // SET THE CENTER
        center: hcmc,

        // SET THE MAP STYLE & ZOOM LEVEL
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        zoom: 17,

        // SET THE BACKGROUND COLOUR
        backgroundColor: "#000",

        // REMOVE ALL THE CONTROLS EXCEPT ZOOM
        panControl: false,
        zoomControl: true,
        mapTypeControl: false,
        scaleControl: false,
        streetViewControl: false,
        overviewMapControl: false,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.LARGE
        }
    };
    map = new google.maps.Map(document.getElementById('map'), mapOptions);

    // SET THE MAP TYPE
    var mapType = new google.maps.StyledMapType(style, { name: "Grayscale" });
    map.mapTypes.set('grey', mapType);
    map.setMapTypeId('grey');

    //CREATE A CUSTOM PIN ICON
    var marker_image = '/bnl/templates/plugins/google-map/images/marker.png';

    var pinIcon = new google.maps.MarkerImage(marker_image, null, null, null, new google.maps.Size(40, 60));

    marker = new google.maps.Marker({
        position: hcmc,
        map: map,
        icon: pinIcon,
        title: 'BnL'
    });
}

if (($('#map').length) != 0) {
    google.maps.event.addDomListener(window, 'load', initialize);
}

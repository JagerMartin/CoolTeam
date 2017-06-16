var trans = {
    DefaultLat: 48.866667,
    DefaultLng: 2.333333,
    DefaultDepartment: "Paris",
    CheckMapDelay: 7e3,
    NoResolvedDepartment: "Erreur de localisation",
    ErrorDepartment: "Coordonnées non valides",
    GeocodingError: "Echec du geocoding pour la raison suivante : "
};
var geocoder;
var map;
var marker = null;
var fromPlace = 0;
var defaultLatLng = new google.maps.LatLng(trans.DefaultLat, trans.DefaultLng);
var myOptions = {
    zoom: 15,
    mapTypeId: google.maps.MapTypeId.TERRAIN,
    scrollwheel: true,
    streetViewControl: false,
    draggableCursor: "crosshair"
};
var mapLoaded = 0;

function defaultMap() {
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    geocoder = new google.maps.Geocoder;

    map.setCenter(defaultLatLng);
    map.setZoom(5);
    mapLoaded = 1;
    bookUp(trans.DefaultDepartment, trans.DefaultLat, trans.DefaultLng);
    if (marker != null) marker.setMap(null);
    marker = new google.maps.Marker({map: map, position: defaultLatLng});
    document.getElementById("observation_init_latitude").value = defaultLatLng.lat();
    document.getElementById("observation_init_longitude").value = defaultLatLng.lng();
    document.getElementById("observation_init_department").value = trans.DefaultDepartment;

    google.maps.event.addListener(map, "click", codeLatLngfromclick);
}

function initialize() {

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            //marker = new google.maps.Marker({map: map, position: pos});
            map.setZoom(15);
            map.setCenter(pos);
            mapLoaded = 1;
            geocoder.geocode({latLng: pos}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        var elt = results[0].address_components;
                        for (var i in elt) {
                            if (elt[i].types[0] == 'administrative_area_level_2') {
                                document.getElementById('observation_init_department').value = elt[i].long_name;
                            }
                        }
                        if (marker != null) marker.setMap(null);
                        marker = new google.maps.Marker({position: pos, map: map});
                        document.getElementById("observation_init_latitude").value = position.coords.latitude;
                        document.getElementById("observation_init_longitude").value = position.coords.longitude;
                        bookUp(results[0].formatted_address, position.coords.latitude, position.coords.longitude);
                    }
                } else {
                    if (marker != null) marker.setMap(null);
                    marker = new google.maps.Marker({position: pos, map: map});
                    document.getElementById("observation_init_latitude").value = position.coords.latitude;
                    document.getElementById("observation_init_longitude").value = position.coords.longitude;
                    bookUp(trans.NoResolvedDepartment, position.coords.latitude, position.coords.longitude);
                }
            })
        }, function () {
            defaultMap()
        })
    } else {
        defaultMap()
    }

}

function codeUpdateLatLng() {
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    var lat = parseFloat(document.getElementById("observation_init_latitude").value);
    var lng = parseFloat(document.getElementById("observation_init_longitude").value);
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder = new google.maps.Geocoder;
    map.setCenter(latlng);
    map.setZoom(15);
    mapLoaded = 1;
    bookUp(trans.DefaultDepartment, trans.DefaultLat, trans.DefaultLng);
    if (marker != null) marker.setMap(null);
    marker = new google.maps.Marker({map: map, position: latlng});
    google.maps.event.addListener(map, "click", codeLatLngfromclick);
}

function codeLatLng() {
    var lat = parseFloat(document.getElementById("observation_init_latitude").value) || 0;
    var lng = parseFloat(document.getElementById("observation_init_longitude").value) || 0;
    var latlng = new google.maps.LatLng(lat, lng);
    map.setZoom(15);
    map.setCenter(latlng);
    geocoder.geocode({latLng: latlng}, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                var elt = results[0].address_components;
                for (var i in elt) {
                    if (elt[i].types[0] == 'administrative_area_level_2') {
                        document.getElementById('observation_init_department').value = elt[i].long_name;
                    }
                }
                if (marker != null) marker.setMap(null);
                marker = new google.maps.Marker({position: latlng, map: map});
                bookUp(document.getElementById("observation_init_department").value, lat, lng)
            }
        } else {
            if (marker != null) marker.setMap(null);
            marker = new google.maps.Marker({position: latlng, map: map});
            document.getElementById("observation_init_department").value = trans.ErrorDepartment;
            document.getElementById("observation_init_latitude").value = "";
            document.getElementById("observation_init_longitude").value = "";
            bookUp(document.getElementById("observation_init_department").value, lat, lng);
        }
    });
    map.setCenter(latlng);
    fromPlace = 0
}

function codeLatLngfromclick(event) {
    var lat = event.latLng.lat();
    var lng = event.latLng.lng();
    var latlng = event.latLng;
    geocoder.geocode({latLng: latlng}, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                var elt = results[0].address_components;
                for (var i in elt) {
                    if (elt[i].types[0] == 'administrative_area_level_2') {
                        document.getElementById('observation_init_department').value = elt[i].long_name;
                    }
                }
                if (marker != null) marker.setMap(null);
                marker = new google.maps.Marker({position: latlng, map: map});
                map.panTo(latlng);
                fromPlace = 0;
                document.getElementById("observation_init_latitude").value = lat;
                document.getElementById("observation_init_longitude").value = lng;
                bookUp(document.getElementById("observation_init_department").value, lat, lng);
            }
        } else {
            if (marker != null) marker.setMap(null);
            marker = new google.maps.Marker({position: latlng, map: map});
            map.panTo(latlng);
            fromPlace = 0;
            document.getElementById("observation_init_department").value = trans.NoResolvedDepartment;
            document.getElementById("observation_init_latitude").value = "";
            document.getElementById("observation_init_longitude").value = "";
            bookUp(document.getElementById("observation_init_department").value, lat, lng);
        }
    })
}

function bookUp(department, latitude, longitude) {
    return false;
}


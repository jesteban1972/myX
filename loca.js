/**
 * script 'locaMap.php'.
 * 
 * JavaScript code for displaying places map
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2018-04-21
*/

function initializeMap() {
    
    /*
     * the map center is determinated from withing the set of all coordinates
     * with the static method Locus::getMapBoundaries(),
     * called at the top of loca.php.
     * the calculated coordinates are stored in the session
     * and retrieved here.
    */
    
    // TODO: this value should come from PHP
    sessionStorage.setItem('mapCenter', '38.325707, 24.390816');
        
    var mapCenterLat = parseFloat(sessionStorage.getItem("mapCenter").split(", ")[0]);
    var mapCenterLng = parseFloat(sessionStorage.getItem("mapCenter").split(", ")[1]);
    
    var mapCenter = new google.maps.LatLng(mapCenterLat, mapCenterLng);
    var mapZoom = 4;
    var mapOptions = {center: mapCenter, zoom: mapZoom};

    var map =
        new google.maps.Map(document.getElementById("mapCanvas"), mapOptions);

    downloadURL ('locaMapFetchXML.php', function(data) {
        
        var xml = data.responseXML;
        
        var loca = xml.documentElement.getElementsByTagName('locus');
        var infowindow = new google.maps.InfoWindow;

        var marker, i;
        var contentString = new Array();
        
        for (i = 0; i < loca.length; i++) {
            
            var locusID = loca[i].getAttribute('locusID');
            
            // get experiences amount:
            var practicaAmount = loca[i].getAttribute('practicaAmount');
            
            var name = loca[i].getAttribute('name');
            //var country = loca[i].getAttribute('country');
            //var kind = loca[i].getAttribute('kind');
            var description = loca[i].getAttribute('description');
            var address = loca[i].getAttribute('address');

            var coordinates;
            var markerColour;

            /*
             * the coordinates can be either exact or generic.
             * when they are generic, they are presented
             * with a marker of a different colour
             */
            if (loca[i].getAttribute('coordExact') !== null) {
                
                coordinates = loca[i].getAttribute('coordExact');
                markerColour = 'FF0000'; // red
                
            } else if (loca[i].getAttribute('coordGeneric') !== null) {
                
                coordinates = loca[i].getAttribute('coordGeneric');
                markerColour = 'FF8C00'; // orange
                
            } else {
                    
                coordinates = '42.665229, 19.6184175'; // map_center
                
            }
            
            // position the marker based on coordinates:
            var coordinateLat = coordinates.split(", ")[0];
            var coordinateLng = coordinates.split(", ")[1];
            var markerPosition = new google.maps.LatLng(coordinateLat, coordinateLng);
            var markerIcon = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='
                    + practicaAmount
                    + '|' + markerColour + '|000000';
            
            marker = new google.maps.Marker({
                position: markerPosition,
                map: map,
                icon: markerIcon});

            // compose the content string for the infowindow:
            contentString[i] = name;
            contentString[i] += " (" + practicaAmount + ")";
            if (description) {
                contentString[i] += "<br />" + description;
            }
            contentString[i] += "<br /><a href=\"locus.php?locusID=" + locusID + "\">Go to place ></a>";
           
           // country, kind, description, address
           
            // add the event listener for click:
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(contentString[i]);
                    infowindow.open(map, marker);
                }
            })(marker, i));

            
        } // for
        
    });

} // function initializeMap

/*
// function bindInfoWindow
function bindInfoWindow(marker, map, infoWindow, html) {
    
    google.maps.event.addListener(marker, 'click', function() {
        
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
        
    });
    
} // function bindInfoWindow
*/

function downloadURL(URL, callback) { // URL = locaMapFetchXML.php
    
    var request = window.ActiveXObject ? new ActiveXObject('Microsoft.XMLHTTP') : new XMLHttpRequest;

    request.onreadystatechange = function() {
   
        if (request.readyState == 4) { // ===?
            
            request.onreadystatechange = doNothing;
            callback(request, request.status);
            
        }
        
    };

    request.open('GET', URL, true);
    
    request.send(null);
    
} // function downloadURL

function doNothing() {}

window.addEventListener('load', initializeMap);
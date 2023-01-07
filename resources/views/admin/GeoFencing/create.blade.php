@extends('admin.layouts.master')
@section('css')
    <style>
        .mapboxgl-popup {
            max-width: 400px;
            font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
        }
    </style>

    <style type="text/css">
      #map {
        padding: 0;
        margin: 0;
        height: 100%;
      }

      #panel {
       /* width: 200px;*/
        font-family: Arial, sans-serif;
        font-size: 13px;
        float: right;
        margin: 5px;
      }

      #color-palette {
        clear: both;
      }

      .color-button {
        width: 14px;
        height: 14px;
        font-size: 0;
        margin: 2px;
        float: left;
        cursor: pointer;
      }

      #delete-button {
        margin-top: 5px;
      }
      .pac-target-input {
            width: 23%;
            padding: 7px;
        }

    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Add GEO Fencing Settings</h4>
                <span class="text-muted mt-1 tx-13 ml-2 mb-0"></span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->

    <div class="row">
        <div class="col-lg-12 col-md-12">

            <div class="card">
                <div class="card-body">

                    <form method="POST" data-parsley-validate="" id="addEditForm" role="form">
                        @csrf
                        <input type="hidden" id="form-method" value="add">
                        <div class="row row-sm">

                            <div class="col-12">
                                <input type="hidden" name="address" id="address">
                                <input type="hidden" name="country" id="country">
                                <input type="hidden" name="locality" id="locality">
                                <input type="hidden" name="restricted_area" id="restricted_area">
                                <input type="hidden" name="restricted_lat" id="restricted_lat">
                                <input type="hidden" name="restricted_lng" id="restricted_lng">
                                <input type="hidden" name="type" id="type">
                                <input type="hidden" name="radius" id="radius">

                                <input type="hidden" name="restricted_latlng" id="restricted_latlng">

                                <input type="hidden" name="lat" id="lat">
                                <input type="hidden" name="long" id="long">
                            </div>

                            <div class="col-md-12">
                              <div class="form-group">
                                  <div class="row">
                                      <div class="col-12 col-md-12">
                                          <div id="panel">
                                              <div id="color-palette"></div>
                                              <div>
                                                  <a href="#" id="delete-button" class="btn btn-info">Delete Selected Shape</a>
                                              </div>
                                              <div id="curpos"></div>
                                              <div id="cursel"></div>
                                              <div id="note"></div>
                                          </div>
                                      </div>
                                      <div class="col-12 col-md-12">
                                          <input id="pac-input" type="text" placeholder="Search Box">
                                          <div id="map" style="height:500px;"></div>
                                      </div>
                                  </div>
                                    </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-0 mt-3 justify-content-end">
                                    <div>
                                       <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="{{ route('admin::geo_fencing.index') }}"
                                           class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->

    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
<script src="{{URL::asset('assets/js/custom/GeoFencing.js')}}"></script>
<script type="text/javascript"
      src="https://maps.google.com/maps/api/js?key=AIzaSyBvRPR8W93pV4cHO6iEabc61OgS3-JPscY&v=3.21.5a&libraries=drawing&signed_in=true&libraries=places,drawing"></script>

<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiaGk1aG9zdCIsImEiOiJja28ycXJ2ZGQxMjJyMm9rNDVhOWxwYW1tIn0.uVHUro3f-OCMCiDsF-DAhw';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [47.990341, 29.378586], //lng,lat 10.818746, 106.629179
        zoom: 7
    });
    console.log('hello');
    var test ='<?php echo $dataArray;?>';
    console.log(test);//ta nhận dữ liệu từ Controller
    var dataMap = JSON.parse(test); //chuyển đổi nó về dạng mà Mapbox yêu cầu

    // ta tạo dòng lặp để for ra các đối tượng
    dataMap.features.forEach(function(marker) {

        //tạo thẻ div có class là market, để hồi chỉnh css cho market
        var el = document.createElement('div');
        el.className = 'marker';

        //gắn marker đó tại vị trí tọa độ
        new mapboxgl.Marker(el)
            .setLngLat(marker.geometry.coordinates)
            .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
                .setHTML('<h3>' + marker.properties.title + '</h3><p>' + marker.properties.description + '</p>'))
            .addTo(map);
    });

</script>
<style>
    #map {
        width: 100%;
        height: 500px;
    }
    .marker {
        background-image: url('https://app.apis.ridewhipp.com/assets/transport_type_marker/depositphotos_89362854-stock-illustration-red-stop-icon-logo.jpg');
        background-repeat:no-repeat;
        background-size:100%;
        width: 50px;
        height: 100px;
        cursor: pointer;
    }
</style>
{{--<script type="text/javascript">--}}
{{--    var drawingManager;--}}
{{--    var geocoder;--}}
{{--    var selectedShape;--}}
{{--    var colors = ['#1E90FF', '#FF1493', '#32CD32', '#FF8C00', '#4B0082'];--}}
{{--    var selectedColor;--}}
{{--    var colorButtons = {};--}}
{{--    var polylines = [];--}}
{{--    function clearSelection() {--}}
{{--        if (selectedShape) {--}}
{{--            if (typeof selectedShape.setEditable == 'function') {--}}
{{--                selectedShape.setEditable(false);--}}
{{--            }--}}
{{--            selectedShape = null;--}}
{{--        }--}}
{{--        // curseldiv.innerHTML = "<b>cursel</b>:";--}}
{{--    }--}}

{{--    function updateCurSelText(shape) {--}}
{{--        posstr = "";--}}
{{--        latitude_co = '';--}}
{{--        lng_co = '';--}}
{{--        if (typeof selectedShape.position == 'object') {--}}
{{--            posstr = selectedShape.position.toUrlValue();--}}
{{--        }--}}
{{--        pathstr = "";--}}
{{--        if (typeof selectedShape.getPath == 'function') {--}}
{{--            //console.log(selectedShape.getPath().getLength());--}}

{{--            for (var i = 0; i < selectedShape.getPath().getLength(); i++) {--}}
{{--                // .toUrlValue(5) limits number of decimals, default is 6 but can do more--}}
{{--                pathstr += selectedShape.getPath().getAt(i).toUrlValue() + " , ";--}}
{{--                latitude_co += selectedShape.getPath().getAt(i).lat()+ ", ";--}}
{{--                lng_co += selectedShape.getPath().getAt(i).lng()+ ", ";--}}

{{--                //var latitude_co =   '{'+ ' "lat":'+ selectedShape.getPath().getAt(i).lat()+ ", "+ ' "lng":'+ selectedShape.getPath().getAt(i).lng() + " }, ";--}}
{{--            }--}}


{{--            //console.log(pathstr);--}}

{{--            //console.log(latitude_co);--}}
{{--            var prev_lat = $("#restricted_lat").val();--}}
{{--            var prev_restricted_latlng = $("#restricted_latlng").val();--}}
{{--            var prev_lng = $("#restricted_lng").val();--}}
{{--            if(prev_lat != '' && prev_lng != '' && prev_restricted_latlng != ''){--}}
{{--                new_lat = prev_lat + " , " + latitude_co;--}}
{{--                new_lng = prev_lng + " , " + lng_co;--}}
{{--                restricted_latlng =  prev_restricted_latlng + " , " + pathstr;--}}
{{--            }else{--}}
{{--                new_lat = latitude_co;--}}
{{--                new_lng = lng_co;--}}
{{--                restricted_latlng = pathstr;--}}
{{--            }--}}

{{--            new_lat = new_lat.replace(/,\s*$/, "");--}}
{{--            new_lng = new_lng.replace(/,\s*$/, "");--}}
{{--            restricted_latlng = restricted_latlng.replace(/,\s*$/, "");--}}

{{--            $("#restricted_lat").val(new_lat);--}}
{{--            $("#restricted_lng").val(new_lng);--}}
{{--            $("#restricted_latlng").val(restricted_latlng);--}}
{{--            //console.log(restricted_latlng);--}}
{{--            //console.log('lng: '+ new_lng);--}}
{{--            console.log(selectedShape.type);--}}
{{--            var polypath = selectedShape.getPath().getArray();--}}
{{--            polylines.push(polypath);--}}
{{--            var elementsJSONs = JSON.stringify(polylines);--}}
{{--            //console.log(elementsJSONs);--}}

{{--            $("#restricted_area").val(elementsJSONs);--}}


{{--        }--}}
{{--        bndstr = "" + selectedShape.getBounds;--}}
{{--        cntstr = "" + selectedShape.getBounds;--}}
{{--        if (typeof selectedShape.getBounds == 'function') {--}}
{{--            var tmpbounds = selectedShape.getBounds();--}}
{{--            cntstr = "" + tmpbounds.getCenter().toUrlValue();--}}
{{--            bndstr = "[NE: " + tmpbounds.getNorthEast().toUrlValue() + " SW: " + tmpbounds.getSouthWest().toUrlValue() + "]";--}}
{{--        }--}}
{{--        cntrstr = "" + selectedShape.getCenter;--}}
{{--        if (typeof selectedShape.getCenter == 'function') {--}}
{{--            cntrstr = "" + selectedShape.getCenter().toUrlValue();--}}
{{--        }--}}
{{--        radstr = "" + selectedShape.getRadius;--}}
{{--        if (typeof selectedShape.getRadius == 'function') {--}}
{{--            radstr = "" + selectedShape.getRadius();--}}
{{--        }--}}

{{--        if(selectedShape.type == 'circle'){--}}
{{--            radius = (radstr/1000);--}}
{{--            var pow = Math.pow(10, 2);--}}
{{--            var radius_in_km =  Math.floor(radius * pow) / pow;--}}
{{--            console.log(radius_in_km);--}}
{{--            cntrstr_arr = cntrstr.split(',');--}}
{{--            $("#restricted_lat").val(cntrstr_arr[0]);--}}
{{--            $("#restricted_lng").val(cntrstr_arr[1]);--}}
{{--            $("#restricted_latlng").val(cntrstr);--}}

{{--            var bndstrr = '[[{'+ ' "lat":'+ cntrstr_arr[0]+ ", "+ ' "lng":'+ cntrstr_arr[1] + " }]]"--}}

{{--            $("#restricted_area").val(bndstrr);--}}
{{--            $("#radius").val(radius_in_km);--}}

{{--        }--}}

{{--        $("#type").val(selectedShape.type);--}}


{{--        //var restricted_area =  $("#restricted_area").val();--}}

{{--        //pathstr += ','+restricted_area;--}}


{{--        // curseldiv.innerHTML = "<b>cursel</b>: " + selectedShape.type + " " + selectedShape + "; <i>pos</i>: " + posstr + " ; <i>path</i>: " + pathstr + " ; <i>bounds</i>: " + bndstr + " ; <i>Cb</i>: " + cntstr + " ; <i>radius</i>: " + radstr + " ; <i>Cr</i>: " + cntrstr ;--}}
{{--    }--}}

{{--    function setSelection(shape, isNotMarker) {--}}
{{--        clearSelection();--}}
{{--        selectedShape = shape;--}}
{{--        if (isNotMarker)--}}
{{--            shape.setEditable(true);--}}
{{--        selectColor(shape.get('fillColor') || shape.get('strokeColor'));--}}
{{--        updateCurSelText(shape);--}}
{{--    }--}}

{{--    function deleteSelectedShape() {--}}
{{--        if (selectedShape) {--}}
{{--            selectedShape.setMap(null);--}}
{{--        }--}}
{{--    }--}}

{{--    function selectColor(color) {--}}
{{--        selectedColor = color;--}}
{{--        for (var i = 0; i < colors.length; ++i) {--}}
{{--            var currColor = colors[i];--}}
{{--            colorButtons[currColor].style.border = currColor == color ? '2px solid #789' : '2px solid #fff';--}}
{{--        }--}}

{{--        // Retrieves the current options from the drawing manager and replaces the--}}
{{--        // stroke or fill color as appropriate.--}}
{{--        var polylineOptions = drawingManager.get('polylineOptions');--}}
{{--        polylineOptions.strokeColor = color;--}}
{{--        drawingManager.set('polylineOptions', polylineOptions);--}}

{{--        var rectangleOptions = drawingManager.get('rectangleOptions');--}}
{{--        rectangleOptions.fillColor = color;--}}
{{--        drawingManager.set('rectangleOptions', rectangleOptions);--}}

{{--        var circleOptions = drawingManager.get('circleOptions');--}}
{{--        circleOptions.fillColor = color;--}}
{{--        drawingManager.set('circleOptions', circleOptions);--}}

{{--        var polygonOptions = drawingManager.get('polygonOptions');--}}
{{--        polygonOptions.fillColor = color;--}}
{{--        drawingManager.set('polygonOptions', polygonOptions);--}}
{{--    }--}}

{{--    function setSelectedShapeColor(color) {--}}
{{--        if (selectedShape) {--}}
{{--            if (selectedShape.type == google.maps.drawing.OverlayType.POLYLINE) {--}}
{{--                selectedShape.set('strokeColor', color);--}}
{{--            } else {--}}
{{--                selectedShape.set('fillColor', color);--}}
{{--            }--}}
{{--        }--}}
{{--    }--}}

{{--    function makeColorButton(color) {--}}
{{--        var button = document.createElement('span');--}}
{{--        button.className = 'color-button';--}}
{{--        button.style.backgroundColor = color;--}}
{{--        google.maps.event.addDomListener(button, 'click', function() {--}}
{{--            selectColor(color);--}}
{{--            setSelectedShapeColor(color);--}}
{{--        });--}}

{{--        return button;--}}
{{--    }--}}

{{--    function buildColorPalette() {--}}
{{--        var colorPalette = document.getElementById('color-palette');--}}
{{--        for (var i = 0; i < colors.length; ++i) {--}}
{{--            var currColor = colors[i];--}}
{{--            var colorButton = makeColorButton(currColor);--}}
{{--            colorPalette.appendChild(colorButton);--}}
{{--            colorButtons[currColor] = colorButton;--}}
{{--        }--}}
{{--        selectColor(colors[0]);--}}
{{--    }--}}

{{--    /////////////////////////////////////--}}
{{--    var map; //= new google.maps.Map(document.getElementById('map'), {--}}
{{--    // these must have global refs too!:--}}
{{--    var placeMarkers = [];--}}
{{--    var input;--}}
{{--    var searchBox;--}}
{{--    var curposdiv;--}}
{{--    var curseldiv;--}}

{{--    function deletePlacesSearchResults() {--}}
{{--        for (var i = 0, marker; marker = placeMarkers[i]; i++) {--}}
{{--            marker.setMap(null);--}}
{{--        }--}}
{{--        placeMarkers = [];--}}
{{--        input.value = ''; // clear the box too--}}
{{--    }--}}

{{--    /////////////////////////////////////--}}
{{--    function initialize() {--}}
{{--        geocoder = new google.maps.Geocoder();--}}
{{--        map = new google.maps.Map(document.getElementById('map'), {--}}
{{--            center: new google.maps.LatLng(24.8998373,91.8258764),//(22.344, 114.048),--}}
{{--            zoom: 12,--}}
{{--            gestureHandling: 'greedy',--}}
{{--        });--}}
{{--        infoWindow = new google.maps.InfoWindow;--}}

{{--        // Try HTML5 geolocation.--}}
{{--        if (navigator.geolocation) {--}}
{{--            navigator.geolocation.getCurrentPosition(function (position) {--}}
{{--                var pos = {--}}
{{--                    lat: position.coords.latitude,--}}
{{--                    lng: position.coords.longitude--}}
{{--                };--}}

{{--                var latitude =  position.coords.latitude;--}}
{{--                var  longitude =  position.coords.longitude;--}}

{{--                codeLatLng(latitude, longitude);--}}

{{--                infoWindow.setPosition(pos);--}}
{{--                //infoWindow.setContent('Your current location is here.');--}}
{{--                //infoWindow.open(map);--}}
{{--                map.setCenter(pos);--}}
{{--            }, function () {--}}
{{--                handleLocationError(true, infoWindow, map.getCenter());--}}
{{--            });--}}
{{--        } else {--}}
{{--            // Browser doesn't support Geolocation--}}
{{--            handleLocationError(false, infoWindow, map.getCenter());--}}
{{--        }--}}
{{--        curposdiv = document.getElementById('curpos');--}}
{{--        curseldiv = document.getElementById('cursel');--}}

{{--        var polyOptions = {--}}
{{--            strokeWeight: 0,--}}
{{--            fillOpacity: 0.45,--}}
{{--            editable: true--}}
{{--        };--}}
{{--        // Creates a drawing manager attached to the map that allows the user to draw--}}
{{--        // markers, lines, and shapes.--}}
{{--        drawingManager = new google.maps.drawing.DrawingManager({--}}
{{--            drawingMode: google.maps.drawing.OverlayType.CIRCLE,--}}
{{--            markerOptions: {--}}
{{--                draggable: true,--}}
{{--                editable: true,--}}
{{--            },--}}
{{--            polylineOptions: {--}}
{{--                editable: true--}}
{{--            },--}}
{{--            rectangleOptions: polyOptions,--}}
{{--            circleOptions: polyOptions,--}}
{{--            polygonOptions: polyOptions,--}}
{{--            map: map--}}
{{--        });--}}

{{--        google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {--}}
{{--            //~ if (e.type != google.maps.drawing.OverlayType.MARKER) {--}}
{{--            var isNotMarker = (e.type != google.maps.drawing.OverlayType.MARKER);--}}
{{--            // Switch back to non-drawing mode after drawing a shape.--}}
{{--            drawingManager.setDrawingMode(null);--}}

{{--            // Add an event listener that selects the newly-drawn shape when the user--}}
{{--            // mouses down on it.--}}
{{--            var newShape = e.overlay;--}}
{{--            newShape.type = e.type;--}}
{{--            google.maps.event.addListener(newShape, 'click', function() {--}}
{{--                setSelection(newShape, isNotMarker);--}}
{{--            });--}}
{{--            google.maps.event.addListener(newShape, 'drag', function() {--}}
{{--                updateCurSelText(newShape);--}}
{{--            });--}}
{{--            google.maps.event.addListener(newShape, 'dragend', function() {--}}
{{--                updateCurSelText(newShape);--}}
{{--            });--}}
{{--            setSelection(newShape, isNotMarker);--}}
{{--            //~ }// end if--}}
{{--        });--}}

{{--        // Clear the current selection when the drawing mode is changed, or when the--}}
{{--        // map is clicked.--}}
{{--        google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);--}}
{{--        google.maps.event.addListener(map, 'click', clearSelection);--}}
{{--        google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);--}}

{{--        buildColorPalette();--}}

{{--        //~ initSearch();--}}
{{--        // Create the search box and link it to the UI element.--}}
{{--        input = /** @type {HTMLInputElement} */( //var--}}
{{--            document.getElementById('pac-input'));--}}
{{--        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);--}}
{{--        //--}}
{{--        var DelPlcButDiv = document.createElement('div');--}}
{{--        //~ DelPlcButDiv.style.color = 'rgb(25,25,25)'; // no effect?--}}
{{--        DelPlcButDiv.style.backgroundColor = '#fff';--}}
{{--        DelPlcButDiv.style.cursor = 'pointer';--}}
{{--        DelPlcButDiv.innerHTML = 'DEL';--}}
{{--        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(DelPlcButDiv);--}}
{{--        google.maps.event.addDomListener(DelPlcButDiv, 'click', deletePlacesSearchResults);--}}

{{--        searchBox = new google.maps.places.SearchBox( //var--}}
{{--            /** @type {HTMLInputElement} */(input));--}}

{{--        // Listen for the event fired when the user selects an item from the--}}
{{--        // pick list. Retrieve the matching places for that item.--}}
{{--        google.maps.event.addListener(searchBox, 'places_changed', function() {--}}
{{--            var places = searchBox.getPlaces();--}}

{{--            if (places.length == 0) {--}}
{{--                return;--}}
{{--            }--}}

{{--            country = '';--}}
{{--            city = '';--}}

{{--            for (var i = 0, marker; marker = placeMarkers[i]; i++) {--}}
{{--                marker.setMap(null);--}}
{{--            }--}}

{{--            // For each place, get the icon, place name, and location.--}}
{{--            placeMarkers = [];--}}
{{--            var bounds = new google.maps.LatLngBounds();--}}
{{--            for (var i = 0, place; place = places[i]; i++) {--}}
{{--                var image = {--}}
{{--                    url: place.icon,--}}
{{--                    size: new google.maps.Size(71, 71),--}}
{{--                    origin: new google.maps.Point(0, 0),--}}
{{--                    anchor: new google.maps.Point(17, 34),--}}
{{--                    scaledSize: new google.maps.Size(25, 25)--}}
{{--                };--}}
{{--                console.log(place.address_components);--}}

{{--                if (place.address_components) {--}}
{{--                    for (var ii = 0; ii < place.address_components.length; ii++) {--}}
{{--                        if (place.address_components[ii].types[0] === 'country') {--}}
{{--                            country = place.address_components[ii].long_name;--}}
{{--                            country_code = place.address_components[ii].short_name;--}}

{{--                        }--}}

{{--                        if (place.address_components[ii].types[0] === 'locality') {--}}
{{--                            city = place.address_components[ii].long_name;--}}


{{--                        }--}}
{{--                    }--}}
{{--                }--}}

{{--                $("#country").val(country);--}}
{{--                $("#locality").val(city);--}}

{{--                console.log(country + city);--}}
{{--                // Create a marker for each place.--}}
{{--                var marker = new google.maps.Marker({--}}
{{--                    map: map,--}}
{{--                    icon: image,--}}
{{--                    title: place.name,--}}
{{--                    position: place.geometry.location--}}
{{--                });--}}


{{--                $("#address").val(place.name);--}}
{{--                $("#lat").val(marker.getPosition().lat());--}}
{{--                $("#long").val(marker.getPosition().lng());--}}

{{--                //console.log(marker.formatted_address);--}}

{{--                placeMarkers.push(marker);--}}

{{--                //bounds.extend(place.geometry.location);--}}
{{--                //bounds.extend(place.geometry.location);--}}
{{--                if (place.geometry.viewport) {--}}
{{--                    // Only geocodes have viewport.--}}
{{--                    bounds.union(place.geometry.viewport);--}}
{{--                } else {--}}
{{--                    bounds.extend(place.geometry.location);--}}
{{--                }--}}

{{--            }--}}

{{--            map.fitBounds(bounds);--}}
{{--            bounds.setZoom();--}}

{{--        });--}}

{{--        // Bias the SearchBox results towards places that are within the bounds of the--}}
{{--        // current map's viewport.--}}
{{--        google.maps.event.addListener(map, 'bounds_changed', function() {--}}
{{--            var bounds = map.getBounds();--}}
{{--            searchBox.setBounds(bounds);--}}
{{--            //curposdiv.innerHTML = "<b>curpos</b> Z: " + map.getZoom() + " C: " + map.getCenter().toUrlValue();--}}
{{--        }); //////////////////////--}}
{{--    }--}}
{{--    google.maps.event.addDomListener(window, 'load', initialize);--}}

{{--    function handleLocationError(browserHasGeolocation, infoWindow, pos) {--}}
{{--        infoWindow.setPosition(pos);--}}
{{--        // infoWindow.setContent(browserHasGeolocation ?--}}
{{--        //    'Error: The Geolocation service failed.' :--}}
{{--        //   'Error: Your browser doesn\'t support geolocation.');--}}
{{--        //infoWindow.open(map);--}}
{{--    }--}}



{{--    function codeLatLng(lat, lng) {--}}

{{--        var latlng = new google.maps.LatLng(lat, lng);--}}
{{--        geocoder.geocode({'latLng': latlng}, function(results, status) {--}}
{{--            if (status == google.maps.GeocoderStatus.OK) {--}}
{{--                console.log(results)--}}
{{--                if (results[1]) {--}}
{{--                    //formatted address--}}
{{--                    //alert(results[0].formatted_address)--}}
{{--                    console.log(results[0].address_components);--}}
{{--                    var country = '';--}}
{{--                    //find country name--}}
{{--                    for (var i=0; i<results[0].address_components.length; i++) {--}}
{{--                        for (var b=0;b<results[0].address_components[i].types.length;b++) {--}}

{{--                            //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate--}}
{{--                            if (results[0].address_components[i].types[b] == "locality") {--}}
{{--                                //this is the object you are looking for--}}
{{--                                city= results[0].address_components[i];--}}
{{--                                break;--}}
{{--                            }--}}

{{--                            if (results[0].address_components[i].types[b] == "country") {--}}
{{--                                //this is the object you are looking for--}}
{{--                                country= results[0].address_components[i];--}}
{{--                                break;--}}
{{--                            }--}}
{{--                        }--}}
{{--                    }--}}


{{--                    $("#address").val(results[0].formatted_address);--}}
{{--                    $("#lat").val(lat);--}}
{{--                    $("#long").val(lng);--}}

{{--                    if(country.long_name){--}}
{{--                        $("#country").val(country.long_name);--}}
{{--                    }--}}

{{--                    if(city.long_name){--}}

{{--                        $("#locality").val(city.long_name);--}}

{{--                    }--}}

{{--                    //city data--}}
{{--                    //alert(city.short_name + " " + city.long_name)--}}


{{--                } else {--}}
{{--                    alert("No results found");--}}
{{--                }--}}
{{--            } else {--}}
{{--                alert("Geocoder failed due to: " + status);--}}
{{--            }--}}
{{--        });--}}
{{--    }--}}

{{--</script>--}}


@endsection

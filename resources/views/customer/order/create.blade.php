@extends('layouts.customer')

@section('content')
<div class="row">
  <div class="col-md-4">
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title">Informations</h4>
        <p class="card-category">*Bien remplir les champs avant de commander</p>
      </div>
      <div class="card-body">
        <form>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group pb-0">
                <label class="bmd-label-floating mb-0">Type de course : </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <select name="order[type]" class="browser-default form-control-sm custom-select">
                  <option value="go" @if ('go' == old('order.type', 'go'))selected="selected"@endif >Aller Simple</option>
                  <option value="back" @if ('back' == old('order.type', 'go'))selected="selected"@endif >Retour Simple</option>
                  <option value="go-back" @if ('go-back' == old('order.type', 'go'))selected="selected"@endif >Aller - Retour</option>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group pb-0">
                <label class="bmd-label-floating mb-0">Club : </label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <select name="order[club]" class="browser-default form-control-sm custom-select">
                  @foreach($clubs as $club)
                    <option value="{{ $club->getKey() }}" @if ($club->getKey() == old('order.club'))selected="selected"@endif >{{ $club->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label class="bmd-label-floating">Nombre de passager</label>
                <input type="number" name="order[place]" class="form-control" value="{{ old('order.place', 1) }}">
              </div>
            </div>
            <div class="col-md-12" id="order_items_0">
              <div class="form-group">
                <label class="bmd-label-floating">Adresse de ramassage</label>
                <input type="text" name="order[items][0][point][name]" id="order_items_0_point_name" class="form-control">
                <input type="hidden" name="order[items][0][point][lat]" id="order_items_0_point_lat" >
                <input type="hidden" name="order[items][0][point][lng]" id="order_items_0_point_lng">
                <input type="hidden" name="order[items][0][point][alt]" id="order_items_0_point_alt">
                <input type="hidden" name="order[items][0][item][type]" id="order_items_0_item_type" value="go">
                <input type="hidden" name="order[items][0][item][distance]" id="order_items_0_item_distance">
                <input type="hidden" name="order[items][0][item][distance_value]" id="order_items_0_item_distance_value">
                <input type="hidden" name="order[items][0][item][duration]" id="order_items_0_item_duration">
                <input type="hidden" name="order[items][0][item][duration_value]" id="order_items_0_item_duration_value">
                <input type="hidden" name="order[items][0][item][direction]" id="order_items_0_item_direction">
              </div>
            </div>
            <div class="col-md-12" id="order_items_1">
              <div class="form-group">
                <label class="bmd-label-floating">Adresse de retours</label>
                <input type="text" name="order[items][1][point][name]" id="order_items_1_point_name" class="form-control">
                <input type="hidden" name="order[items][1][point][lat]" id="order_items_1_point_lat" >
                <input type="hidden" name="order[items][1][point][lng]" id="order_items_1_point_lng">
                <input type="hidden" name="order[items][1][point][alt]" id="order_items_1_point_alt">
                <input type="hidden" name="order[items][1][item][type]" id="order_items_1_item_type" value="back">
                <input type="hidden" name="order[items][1][item][distance]" id="order_items_1_item_distance">
                <input type="hidden" name="order[items][1][item][distance_value]" id="order_items_1_item_distance_value">
                <input type="hidden" name="order[items][1][item][duration]" id="order_items_1_item_duration">
                <input type="hidden" name="order[items][1][item][duration_value]" id="order_items_1_item_duration_value">
                <input type="hidden" name="order[items][1][item][direction]" id="order_items_1_item_direction">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <!-- Default unchecked -->
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="order[privatized]" value="0">
                    <input type="checkbox" name="order[privatized]" value="1" class="custom-control-input" id="defaultUnchecked">
                    <label class="custom-control-label" for="defaultUnchecked">Privatiser le véhicule</label>
                </div>
              </div>
            </div>

          </div>
          <button type="submit" class="btn btn-primary pull-right">Commander</button>
          <div class="clearfix"></div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <div class="card card-profile">
      <div class="card-body" >
        <div id="map" style="float:left;width:100%;height:500px;"></div>
      </div>
    </div>
  </div>
</div>
@endsection
  
@section('javascript')
  @parent
  <script>
      var clubs = @json($clubs);
      var origin = {lat: {{ $clubs[0]->point->lat }}, lng: {{ $clubs[0]->point->lng }}};
      var service;
      var directionsService;
      var directionsRenderer;
      var stepDisplay;
      var geocoder;
      var infowindow;
      var map;
      var marker;
      var markers = [];
      var zoom = {{env('MAP_ZOOM', 15)}};
      var uluru = {lat: {{ env('DEFAULT_LOCATION_LAT', -18.00) }}, lng: {{ env('DEFAULT_LOCATION_LNG', 47.00) }}};
      var destinationIcon = 'https://chart.googleapis.com/chart?' + 'chst=d_map_pin_letter&chld=D|FF0000|000000';
      var originIcon = 'https://chart.googleapis.com/chart?' + 'chst=d_map_pin_letter&chld=O|FFFF00|000000';

      function initMap() {
        // The geocoder
        geocoder = new google.maps.Geocoder();
        
        // The info window
        infowindow = new google.maps.InfoWindow;
        
        // The map, centered at Uluru
        map = new google.maps.Map(document.getElementById('map'), {zoom: zoom, center: uluru});

        // The marker, positioned at Uluru
        marker = new google.maps.Marker({draggable: true, position: uluru, map: map});

        map.addListener('center_changed', function() {
          // 3 seconds after the center of the map has changed, pan back to the
          // marker.
          window.setTimeout(function() {
            map.panTo(marker.getPosition());
          }, 3000);
        });
        
        map.addListener('click', function(e) {
          placeMarkerAndPanTo(e.latLng, map);
          geocodeLatLng(e.latLng);
          calcRoute(origin, e.latLng);
          //getDistance([origin], [e.latLng]);
        });

        marker.addListener('click', function() {
          map.setZoom(zoom);
          map.setCenter(marker.getPosition());
        });
        
        // The distance matrix
        service = new google.maps.DistanceMatrixService;
        
        directionsService = new google.maps.DirectionsService();
        
        directionsRenderer = new google.maps.DirectionsRenderer();
        directionsRenderer.setMap(map);
        //directionsRenderer.setPanel(document.getElementById('directionsPanel'));
        
        // Instantiate an info window to hold step text.
        stepDisplay = new google.maps.InfoWindow();
      }
    
      function calcRoute(start, end) {
        var request = {
          origin:start,
          destination:end,
          travelMode: 'DRIVING'
        };
        directionsService.route(request, function(response, status) {
          console.log(response);
          if (status == 'OK') {
            directionsRenderer.setDirections(response);
            showSteps(response);
          }
        });
      }
    
      function showSteps(directionResult) {
        // For each step, place a marker, and add the text to the marker's
        // info window. Also attach the marker to an array so we
        // can keep track of it and remove it when calculating new
        // routes.
        var myRoute = directionResult.routes[0].legs[0];

        for (var i = 0; i < myRoute.steps.length; i++) {
            var marker = new google.maps.Marker({
              position: myRoute.steps[i].start_point,
              map: map
            });
            attachInstructionText(marker, myRoute.steps[i].instructions);
            markerArray[i] = marker;
        }
      }

      function attachInstructionText(marker, text) {
        google.maps.event.addListener(marker, 'click', function() {
          stepDisplay.setContent(text);
          stepDisplay.open(map, marker);
        });
      }

      function drawPath(flightPlanCoordinates) {
        var flightPath = new google.maps.Polyline({
          path: flightPlanCoordinates,
          geodesic: true,
          strokeColor: '#FF0000',
          strokeOpacity: 1.0,
          strokeWeight: 2
        });

        flightPath.setMap(map);
      }
    
      function getDistance(origins, destinations) {
        service.getDistanceMatrix({
            origins: origins,
            destinations: destinations,
            travelMode: 'DRIVING',
            unitSystem: google.maps.UnitSystem.METRIC,
            avoidHighways: false,
            avoidTolls: false
          }, function(response, status) {

            console.log(response);
          
            if (status !== 'OK') {
              alert('Error was: ' + status);
            } else {
              var originList = response.originAddresses;
              var destinationList = response.destinationAddresses;
              deleteMarkers(markers);

              var showGeocodedAddressOnMap = function(asDestination) {
                var icon = asDestination ? destinationIcon : originIcon;
                return function(results, status) {
                  if (status === 'OK') {
                    //map.fitBounds(bounds.extend(results[0].geometry.location));
                    markers.push(new google.maps.Marker({map: map,position: results[0].geometry.location, icon: icon}));
                  } else {
                    alert('Geocode was not successful due to: ' + status);
                  }
                };
              };
              
              var html = "";
              for (var i = 0; i < originList.length; i++) {
                var results = response.rows[i].elements;
                console.log(results);
                geocoder.geocode({'address': originList[i]},showGeocodedAddressOnMap(false));
                for (var j = 0; j < results.length; j++) {
                  geocoder.geocode({'address': destinationList[j]},showGeocodedAddressOnMap(true));
                  html += originList[i] + ' to ' + destinationList[j] + ': ' + results[j].distance.text + ' in ' + results[j].duration.text + '<br>';
                }
              }
              console.log(html);
            }
          });
      }
    
      function deleteMarkers(markers) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(null);
        }
        markers = [];
      }
        
      function geocodeAddress() {
        var address = document.getElementById('order_items_0_point_name').value;
        geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == 'OK') {
            map.setCenter(results[0].geometry.location);
            marker = new google.maps.Marker({map: map,position: results[0].geometry.location});
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }
    
      function geocodeLatLng(latlng) {
        geocoder.geocode({'location': latlng}, function(results, status) {
          if (status === 'OK') {
            if (results[0]) {
              map.setZoom(zoom);
              marker.setMap(null);
              marker = new google.maps.Marker({position: latlng, map: map});
              infowindow.setContent(results[0].formatted_address);
              infowindow.open(map, marker);
              document.getElementById('order_items_0_point_name').value = results[0].formatted_address;
              document.getElementById('order_items_0_point_lat').value = latlng.lat;
              document.getElementById('order_items_0_point_lng').value = latlng.lng;
            } else {
              window.alert('No results found');
            }
          } else {
            window.alert('Geocoder failed due to: ' + status);
          }
        });
      }

      function placeMarkerAndPanTo(latLng, map) {
        marker.setMap(null);
        marker = new google.maps.Marker({draggable: true, position: latLng, map: map});
        map.panTo(latLng);
      }

      function decode(encoded){
        var points=[ ]
        var index = 0, len = encoded.length;
        var lat = 0, lng = 0;
        while (index < len) {
          var b, shift = 0, result = 0;
          do {
            b = encoded.charAt(index++).charCodeAt(0) - 63;//finds ascii                                                                                    //and substract it by 63
            result |= (b & 0x1f) << shift;
            shift += 5;
          } while (b >= 0x20);

          var dlat = ((result & 1) != 0 ? ~(result >> 1) : (result >> 1));
          lat += dlat;
          shift = 0;
          result = 0;
          do {
            b = encoded.charAt(index++).charCodeAt(0) - 63;
            result |= (b & 0x1f) << shift;
            shift += 5;
          } while (b >= 0x20);
          
          var dlng = ((result & 1) != 0 ? ~(result >> 1) : (result >> 1));
          lng += dlng;
          points.push({latitude:( lat / 1E5),longitude:( lng / 1E5)})  
        }
        return points
      }
  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&callback=initMap" async defer></script>
@endsection

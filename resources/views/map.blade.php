<!DOCTYPE html>
<html>
  <head>
    <style>
       #map {
        height: 600px;
        width: 100%;
       }
    </style>
  </head>
  <body>
    <h3>Properties Map</h3>
    <div id="map"></div>
    <script>
      function initMap() {
        var map;
        var bounds = new google.maps.LatLngBounds();
        map = new google.maps.Map(document.getElementById("map"), {
          zoom: 3
        });

          //Set array of markers
          var markers = [

            @for ($i = 0; $i < count($properties); $i++)

              ['{{preg_replace( "/\r|\n/", " ", $properties[$i]->address)}}', {{$properties[$i]->latitude}},{{$properties[$i]->longitude}}],

            @endfor

         ];

          // Loop through our array of markers & place each one on the map
         for( i = 0; i < markers.length; i++ ) {
             var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
             bounds.extend(position);
             marker = new google.maps.Marker({
                 position: position,
                 map: map,
                 title: markers[i][0]
             });

             // Automatically center the map fitting all markers on the screen
             map.fitBounds(bounds);
         }

      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASjWEo23m5zLJDGElBdlIm_0i4xpDLOzA&callback=initMap">
    </script>
  </body>
</html>

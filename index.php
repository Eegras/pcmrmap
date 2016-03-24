<?php
session_start();
?>
<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>PCMR User Map</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="gmaps.js"></script>
    <style type="text/css">
    body {
      font-family: 'Roboto', sans-serif;
      margin: 0px;
      padding: 0px;
    }
    #header {
      color: #FFFFFF;
      position: absolute; 
      left: 0; 
      top: 0; 
      height: 100px; 
      right: 0; 
      background: #333333; 
      padding-top:2px; 
      padding-bottom: 2px;
      border-bottom: 2px solid #FACA04;
    }
    #header img {
      float: left;
      margin-right: 10px;
      margin-left: 10px;
    }
    #header input {
      font-size: 2em;
      display: block;
      border-radius: 10px;
    }
    #map {
      position: absolute;
      left: 0; 
      right: 0; 
      bottom: 0; 
      top: 100px;
    }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js"
            type="text/javascript"></script>
    <script type="text/javascript">
      lastmarker = '';
      $(document).ready(function(){
        infoWindow = new google.maps.InfoWindow({});
        map = new GMaps({
          div: '#map',
          lat: 0,
          lng: 0,
          zoom: 2,
          click: function(e){
            addMarker(JSON.stringify(e.latLng));
            $("#save").show();
          }
        });

        map.loadFromKML({
          url: 'http://www.eegras.com/map/phpsqlajax_genxml.php?rand='+Math.random(),
          suppressInfoWindows: true,
          preserveViewport:true
        });


        $('#save').click(function(){
          $.ajax({
            url: 'phpsqlajax_insert.php?rand='+Math.random(),
            type: 'post',
            data: {'lat': lastmarker.getPosition().lat(), 'lng': lastmarker.getPosition().lng(), 'submitted': 'yes'},
            success: function(){
              map.loadFromKML({
                url: 'http://www.eegras.com/map/phpsqlajax_genxml.php?rand='+Math.random(),
                suppressInfoWindows: true,
                preserveViewport:true
              });
              location.reload();
            }
          });
          $('#save').hide();
        });
        $("#clear").click(function(){
          $.ajax({
            url: 'phpsqlajax_insert.php?rand='+Math.random(),
            type: 'post',
            data: {'clr': 'yes'},
            success: function(){
              map.loadFromKML({
                url: 'http://www.eegras.com/map/phpsqlajax_genxml.php?rand='+Math.random(),
                suppressInfoWindows: true,
                preserveViewport:true
              });
              location.reload();
            }
          });
        });
      });
      function addMarker(latLng){
        latLng = JSON.parse(latLng);
        map.removeMarker(lastmarker);
        lastmarker = map.addMarker({
          lat: latLng.lat,
          lng: latLng.lng,
          title: 'New',
          click: function(e){
            console.log(e);
          }
        });
      }
    </script>

  </head>

  <body>
    <div id="map"></div>
    <div id="header"><img src="logostrokeroboto.png" /><input type="button" value="Clear my marker" id="clear" /><input type="button" value="Save!" id="save" style="display: none;"></div>
  </body>

</html>
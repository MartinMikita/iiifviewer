<!DOCTYPE html>
<html>
<head>
<title>OpenLayers 3 QtGDAL Tiles</title>
<meta http-equiv="imagetoolbar" content="no"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<style type="text/css">
html, body { margin:0; padding: 0; height: 100%; width: 100%; }
body { width:100%; height:100%; background: #ffffff; }
#mapWebGl { position: absolute; height: 90%; width: 100%; background-color: #FFFFFF; }
#map { position: absolute; height: 100%; width: 100%; background-color: #FFFFFF; }
.olImageLoadError {  display: none !important; }
label { text-align: center; display: block; max-width: 100%; margin: 6px 0 4px 1px; font-weight: bold; font-size: 12.6px; color: #393939; }
input, select, button { vertical-align: top; }
input[type="range"] { display: block; width: 100%; }
.range { float: left; width: 150px; }
#controls { height: 10%; }
table tr td { padding-left: 40px; padding-right: 40px; }
</style>
<script type="text/javascript">
<?php
include('build/ol3.js');
include('build/ol-iiifviewer.js');
?>

  var viewer;

  function loadGdalFile(size, zoom, fname, useWebGL)
  {
    useWebGL = (typeof useWebGL === 'undefined') ? true : useWebGL;
    
    var zmin = zoom[0];
    var zmax = zoom[1];
    var factors = [];
    for(var i = zmin; i <= zmax; i++)
      factors.push( 1 << i );
    var data = {
      "@id" : "gdal://" + fname.replace(/[ .]/g, "-"),
      "width" : size[0],
      "height" : size[1],
      "scale_factors" : factors,
      "tile_width" : 256,
      "tile_height" : 256,
      "formats" : [ "png" ],
      "qualities" : [ "native" ],
    };
    var init = function(viewer) {
      var map = viewer.getMap();
      var layer = map.getLayers().item(0);

      var brightness = document.getElementById('brightness');
      brightness.oninput = function(e) {
        layer.setBrightness(parseFloat(brightness.value));
      };

      var contrast = document.getElementById('contrast');
      contrast.oninput = function(e) {
        layer.setContrast(parseFloat(contrast.value));
      };

      var hue = document.getElementById('hue');
      hue.oninput = function(e) {
        layer.setHue(parseFloat(hue.value));
      };

      var saturation = document.getElementById('saturation');
      saturation.oninput = function(e) {
        layer.setSaturation(parseFloat(saturation.value));
      };
    };

    if (ol.has.WEBGL && useWebGL) {
      document.getElementById('no-webgl').style.display = 'none';
      document.getElementById('controls').style.display = 'block';
      document.getElementById('map').style.display = 'none';
      document.getElementById('mapWebGl').style.display = 'block';

      viewer = new IiifViewer('mapWebGl', data, init, true);
    }
    else {
      document.getElementById('no-webgl').style.display = 'none';
      document.getElementById('controls').style.display = 'none';
      document.getElementById('map').style.display = 'block';
      document.getElementById('mapWebGl').style.display = 'none';

      viewer = new IiifViewer('map', data);
    }
  }

</script>
</head>
<body>
<div id="no-webgl" style="background:red;width:600px;">
      This viewer requires a browser that supports <a href="http://get.webgl.org/">WebGL</a>.
</div>
<div id="controls">
<form>
  <table width="100%">
  <tr>
    <td><label>Brightness:</label><input id="brightness" type="range" min="-1" max="1" step="0.1" value="0" /></td>
    <td><label>Contrast:</label><input id="contrast" type="range" min="0" max="5" step="0.1" value="1" /></td>
    <td><label>Hue:</label><input id="hue" type="range" min="-3.14" max="3.14" step="0.1" value="0" /></td>
    <td><label>Saturation:</label><input id="saturation" type="range" min="0" max="5" step="0.1" value="1" /></td>
  </tr>
  </table>
</form>
</div>
<div id="mapWebGl">
</div>
<div id="map">
</div>
</body>
</html>

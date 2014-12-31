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
#map { position: absolute; height: 100%; width: 100%; background-color: #FFFFFF; }
.olImageLoadError {  display: none !important; }
</style>
<script type="text/javascript">
<?php
include('build/iiifviewer.js');
?>

  function loadGdalFile(size, zoom, fname)
  {
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

    new IiifViewer('map', data);
    return;
  }

</script>
</head>
<body>
<div id="map"></div>
</body>
</html>

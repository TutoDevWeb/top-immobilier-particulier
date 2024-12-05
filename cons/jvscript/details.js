//------------------------------------------------------------------------------------------------
function load_map() {
  if (GBrowserIsCompatible() && maps_actif) {
    map = new GMap2(document.getElementById("map"));
    var point = new GLatLng(maps_lat,maps_lng);
    map.setCenter(point,13);
    map.addControl(new GSmallMapControl());
    var marker = new GMarker(point);
		map.addOverlay(marker);
    if ( quart != '' ) {
		  GEvent.addListener(marker,"click", function() {
        var myHtml = "<div style='text-align: center;'><br/>"+quart+"</div>";
        map.openInfoWindowHtml(point, myHtml);
      });
		}
  }
}

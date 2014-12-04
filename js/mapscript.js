  
  var view = new ol.View({
      center: [0,0],
      zoom: 4
   }); 
  
  var  osm = new ol.layer.Tile({source: new ol.source.OSM()});
  
 /** 
  * var gmap = new google.maps.Map
  */
  
  /**
   	var  bing = new ol.layer.Tile({
  	 source: new ol.source.BingMaps({
  	 	key: ,
  	 	style: 
  	 	})
  	})
  */
 
  //var layer = mapselection();
   
  var map = new ol.Map({
    target: 'map',
    layers: [osm],
    view: view});


/**function mapselection(){
*	if(){return osm;}
*   if(){return bingMap}
*   else{return gmap} //default map
*}
*/

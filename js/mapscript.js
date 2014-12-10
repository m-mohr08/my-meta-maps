function drawmap() {
	var view = new ol.View({
		center : [0, 0],
		zoom : 2
	});

	var map = new ol.Map({
		layers : [new ol.layer.Tile({
			source : new ol.source.OSM()
		})],
		target : 'map',
		controls : ol.control.defaults({
			attributionOptions : /** @type {olx.control.AttributionOptions} */( {
				collapsible : false
			})
		}),
		view : view
	});
}
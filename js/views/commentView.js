/**
 * View for GeodataShow; showing geodata
 * Extend ContentView
 */
GeodataShowView = ContentView.extend({
	el: function () {
		return $('#showGeodata');
	},
	getPageContent: function () {
		return this.options.geodata;
	},
	getPageTemplate: function () {
		return '/api/internal/doc/showGeodataBit';
	}
});



/**
 * View for CommentAddFirstStep
 * Extend ModalView
 */
CommentAddViewStep1 = ModalView.extend({
	getPageTemplate: function () {
		return '/api/internal/doc/addCommentFirstStep';
	},
	events: {
		"click #addCommentBtn": "createComment"
	},
	/*
	 * This function is called when anybody creates a comment
	 */
	createComment: function (event) {
		Debug.log('Try to get metadata');

		// Creates primary details of a comment with typed in values
		var details = {
			"url": $("#inputURL").val(),
			"datatype": $("#inputDataType").val()
		};

		// Creates a new CommentAdd-Model
		commentAddFirstStepController(new CommentAddFirstStep(), details);
	}
});

/**
 * View for CommentAddSecondStep; will only shown after CommentAddViewStep1
 * Extend ContentView
 */
CommentAddViewStep2 = ContentView.extend({
	draw: null,
	map: null,
	featureVector: null,
	feature: null,
	parser: new ol.format.WKT(),
	getPageTemplate: function () {
		return '/api/internal/doc/addCommentSecondStep';
	},
	getPageContent: function () {
		return this.options.metadata;
	},
	initialize: function () {
		if (typeof this.options.metadata.url === undefined) {
			MessageBox.addError('Es ist ein Fehler beim Laden der Metadaten aufgetreten. Bitte versuchen Sie erneut.');
		}
		else {
			this.render();
		}
	},
	onLoaded: function () {

		$('#ratingComment').barrating({showSelectedRating: false});
		$("#inputDataType option[value='" + this.options.metadata.datatype + "']").attr('selected', true);

		// this for the callbacks
		var that = this;


		var basemap = new ol.layer.Tile({
			source: new ol.source.OSM(),
		});

		this.featureVector = new ol.source.Vector();
		this.featureVector.on('addfeature', function (event) {
			if (that.feature !== null) {
				that.featureVector.removeFeature(that.feature); // Remove the previous feature
			}
			that.feature = event.feature;
		});

		// set the style of the bbox polygon
		var bboxStyle = new ol.style.Style({
			stroke: new ol.style.Stroke({
				color: 'rgba(0,139,0,1)',
				width: 2
			})
		});

		var bboxLayer = new ol.layer.Vector({
			source: new ol.source.Vector(),
			style: bboxStyle
		});

		var featureLayer = new ol.layer.Vector({
			source: this.featureVector,
			style: new ol.style.Style({
				fill: new ol.style.Fill({
					color: 'rgba(255, 255, 255, 0.2)'
				}),
				stroke: new ol.style.Stroke({
					color: '#ffcc33',
					width: 2
				}),
				image: new ol.style.Circle({
					radius: 7,
					fill: new ol.style.Fill({
						color: '#ffcc33'
					})
				})
			})
		});

		var view = new ol.View({
			center: [0, 0],
			zoom: 2
		});

		this.map = new ol.Map({
			layers: [basemap, bboxLayer, featureLayer],
			target: 'mapAddComm',
			view: view
		});

		if (this.options.metadata.metadata.bbox) {
			// Parse the bbox
			var geom = this.parser.readGeometry(this.options.metadata.metadata.bbox);
			if (geom) {
				geom.transform(this.getServerCrs(), this.getMapCrs());
				// fit the extent to the given bbox
				view.fitExtent(geom.getExtent(), this.map.getSize());
				bboxLayer.getSource().addFeature(new ol.Feature({
					geometry: geom,
					projection: this.getMapCrs()
				}));
			}
		}

		/**
		 * Let user change the geometry type.
		 * @param {Event} e Change event.
		 */
		$("#geomType").change(function (e) {
			that.map.removeInteraction(that.draw);
			that.addInteraction();
		});

		this.addInteraction();
	},
	addInteraction: function () {
		var value = $("#geomType").val();
		if (value !== 'None') {
			this.draw = new ol.interaction.Draw({
				source: this.featureVector,
				type: /** @type {ol.geom.GeometryType} */ (value)
			});
			this.map.addInteraction(this.draw);
		}
	},
	getServerCrs: function () {
		return 'EPSG:4326';
	},
	getMapCrs: function () {
		return 'EPSG:3857';
	},
	events: {
		"click #addCommentSecondBtn": "createComment"
	},
	getGeometryFromMap: function () {
		if (this.feature !== null) {
			var geom = this.feature.getGeometry();
			geom.transform(this.getMapCrs(), this.getServerCrs());
			return this.parser.writeGeometry(geom);
		}
		else {
			return null;
		}
	},
	/*
	 * This function is called when anybody creates a comment
	 */
	createComment: function (event) {
		Debug.log('Try to add comment');

		// Creates further details of a comment with typed in values
		var details = {
			"url": $("#inputURL").val(),
			"datatype": $("#inputDataType").val(),
			"layer": $("#inputLayer").val(),
			"text": $("#inputText").val(),
			"geometry": this.getGeometryFromMap(),
			"start": $("#inputStartDate").val(),
			"end": $("#inputEndDate").val(),
			"rating": $("#ratingComment").val(),
			"title": $("#inputTitle").val()
		};

		// Creates a new CommentAdd-Model
		commentAddSecondStepController(new CommentAddSecondStep(), details);
	}
});

/**
 * View for CommentsToGeodata
 * Extend ModalView
 */
CommentsShowView = ModalView.extend({
	getPageContent: function () {
		return this.options.geodata;
	},
	onOpened: function () {
		var that = this;

		$('[data-toggle="popover"]').popover({
			html: true
		});

		var view = new ol.View({
			center: [0, 0],
			zoom: 2
		});
		
		var map = new ol.Map({
			layers: [
				new ol.layer.Tile({
					source: new ol.source.OSM()
				})
			],
			target: 'commentviewmap',
			controls: ol.control.defaults({
				attributionOptions: /** @type {olx.control.AttributionOptions} */({
					collapsible: false
				})
			}),
			view: view
		});

		// When other layer is selected remove and add the new data to the map
		var panels = $('#commentAccordion').find('.panel');
		panels.on('hide.bs.collapse', function (event) {
			var layerId = $(event.currentTarget).data('layer');
			that.onLayerHidden(layerId);
		});
		panels.on('shown.bs.collapse', function (event) {
			var geodata = that.getPageContent();
			var layerId = $(event.currentTarget).data('layer');
			var layer = null;
			// Find layer
			if (layerId === '') {
				// General comments
				layer = {
					id: null,
					title: Lang.t('generalComm'),
					bbox: geodata.metadata.bbox,
					comments: geodata.comments
				};
			}
			else {
				// One of the layers, find it...
				if (geodata.layer) {
					_.each(geodata.layer, function(element) {
						if (element.id === layerId) {
							layer = element;
						}
					});
				}
			}
			if (layer !== null) {
				that.onLayerShown(layer);
			}
		});

	},
	
	onLayerHidden: function(layerId) {
		Debug.log('Layer ' + layerId + ' hidden');

		// TODO: Remove data from map
	},
	
	onLayerShown: function(data) {
		Debug.log('Layer ' + data.id + ' shown');

		// TODO: Add data to map
		
		// Load WMS/WMTS data
		var datatype = this.options.geodata.metadata.datatype;
		if (datatype == 'wms') {
			this.loadWms(this.options.geodata.url, data.id);
		}
		else if (datatype == 'wmts') {
			this.loadWmts(this.options.geodata.url, data.id);
		}
	},
	
	loadWms: function(url, layerId) {
		Debug.log('Loading WMS ' + url + ' with layer ' + layerId);
		// TODO: Add code to show the WMS on the map
	},
	
	loadWmts: function(url, layerId) {
		Debug.log('Loading WMTS ' + url + ' with layer ' + layerId);
		// TODO: Add code to show the WMTS on the map
	},
	
	getPageTemplate: function() {
		return '/api/internal/doc/showCommentsToGeodata';
	}
});
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
	drawType: null,
	getPageTemplate: function () {
		return '/api/internal/doc/addCommentSecondStep';
	},
	getPageContent: function () {
		return this.options.metadata;
	},
	initialize: function () {
		if (typeof this.options.metadata.url === undefined) {
			MessageBox.addError(Lang.t('failedLoadMeta'));
		}
		else {
			this.render();
		}
	},
	onLoaded: function () {

		$('#ratingComment').barrating({showSelectedRating: false});
		$("#inputDataType option[value='" + this.options.metadata.datatype + "']").attr('selected', true);
		$("#inputLayer option[value='" + this.options.layerID + "']").attr('selected', true);
		Debug.log(this.options.metadata);

		// this for the callbacks
		var that = this;

		this.featureVector = new ol.source.Vector();
		this.featureVector.on('addfeature', function (event) {
			if (that.feature !== null) {
				that.featureVector.removeFeature(that.feature); // Remove the previous feature
			}
			that.feature = event.feature;
		});

		var bboxLayer = Mapping.getBBoxLayer(Mapping.getBBoxStyle(false));
		var layers = [bboxLayer, Mapping.getFeatureLayer(this.featureVector)];

		this.map = new ol.Map({
			layers: Mapping.getBasemps(layers),
			target: 'mapAddComm',
			controls: Mapping.getControls([
				Mapping.createCustomControl('<img src="/img/draw/none.png" />', 'Disable drawing', 'draw-none', function () {
					that.setDrawType(null);
				}),
				Mapping.createCustomControl('<img src="/img/draw/point.png" />', 'Draw a Point', 'draw-point', function () {
					that.setDrawType('Point');
				}),
				Mapping.createCustomControl('<img src="/img/draw/line.png" />', 'Draw a Line', 'draw-line', function () {
					that.setDrawType('LineString');
				}),
				Mapping.createCustomControl('<img src="/img/draw/polygon.png" />', 'Draw a Polygon', 'draw-polygon', function () {
					that.setDrawType('Polygon');
				})
			]),
			view: Mapping.getDefaultView()
		});

		if (this.options.metadata.metadata.bbox) {
			Mapping.addWktToLayer(this.map, bboxLayer, this.options.metadata.metadata.bbox, true);
		}

		/**
		 * Let user change the geometry type.
		 * @param {Event} e Change event.
		 */
		$("#geomType").change(function (e) {
			that.addInteraction();
		});

		this.addInteraction();
	},
	setDrawType: function (type) {
		this.map.removeInteraction(this.draw);
		this.drawType = type;
		this.addInteraction();
	},
	addInteraction: function () {
		if (this.drawType !== null) {
			this.draw = new ol.interaction.Draw({
				source: this.featureVector,
				type: /** @type {ol.geom.GeometryType} */ (this.drawType)
			});
			this.map.addInteraction(this.draw);
		}
	},
	events: {
		"click #addCommentSecondBtn": "createComment"
	},
	getGeometryFromMap: function () {
		if (this.feature !== null) {
			return Mapping.toWkt(this.feature.getGeometry(), this.map);
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
			url: $("#inputURL").val(),
			datatype: $("#inputDataType").val(),
			layer: $("#inputLayer").val(),
			text: $("#inputText").val(),
			geometry: this.getGeometryFromMap(),
			start: $("#inputStartDate").val(),
			end: $("#inputEndDate").val(),
			rating: $("#ratingComment").val(),
			title: $("#inputTitle").val()
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
	map: null,
	serviceLayer: new ol.layer.Tile(),
	geometryLayer: new ol.layer.Vector({
		source: new ol.source.Vector(),
		style: Mapping.getBBoxStyle()
	}),
	bboxLayer: null,
	getPageContent: function () {
		return this.options.geodata;
	},
	onOpened: function () {
		var that = this;

		$('[data-toggle="popover"]').popover({
			html: true
		});
		
		this.bboxLayer = Mapping.getBBoxLayer(Mapping.getBBoxStyle(false));
		this.map = new ol.Map({
			layers: Mapping.getBasemps([this.bboxLayer, this.geometryLayer, this.serviceLayer]),
			target: 'commentviewmap',
			controls: Mapping.getControls(),
			view: Mapping.getDefaultView()
		});

		// Without this the map is not shown on initial loading
		$('#ModalShowCommentsToGeodata').on('shown.bs.modal', function () {
			that.map.updateSize();

			// Execute the onLayerShown event for the box visible by default
			var defaultLayer = $('#showCommentsToGeodata').find('.in').parent().data('layer');
			that.onLayerShown(defaultLayer);
		});

		// When other layer is selected remove and add the new data to the map
		var panels = $('#commentAccordion').find('.panel');
		panels.on('hide.bs.collapse', function (event) {
			var layerId = $(event.currentTarget).data('layer');
			that.onLayerHidden(layerId);
		});
		panels.on('shown.bs.collapse', function (event) {
			var layerId = $(event.currentTarget).data('layer');
			that.onLayerShown(layerId);
		});
	},
	onLayerHidden: function (layerId) {
		Debug.log('Layer ' + layerId + ' hidden');

		// Remove the bbox from the map
		this.bboxLayer.getSource().clear();

		// TODO: Remove features from map
	},
	onLayerShown: function(layerId) {
		Debug.log('Layer ' + layerId + ' shown');

		var geodata = this.getPageContent();
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
				_.each(geodata.layer, function (element) {
					if (element.id === layerId) {
						layer = element;
					}
				});
			}
		}
		if (layer !== null) {
			this.fillLayer(layer);
		}	
	},
	fillLayer: function (data) {
		// Get the bbox from the layer or as fallback from the global dataset
		var bbox = data.bbox ? data.bbox : this.options.geodata.metadata.bbox;
		// Add bbox extent and fit it into the window
		if (bbox) {
			Mapping.addWktToLayer(this.map, this.bboxLayer, bbox, true);
		}
			
		// Load WMS/WMTS data
		var datatype = this.options.geodata.metadata.datatype;
		if (datatype == 'wms') {
			this.loadWms(this.options.geodata.url, data.id);
		}
		else if (datatype == 'wmts') {
			this.loadWmts(this.options.geodata.url, data.id);
		}
		
		// TODO: Add features to map
		for (var index = 0; index < data.comments.length; index++){
			Mapping.addWktToLayer(this.map, this.geometryLayer, data.comments[index].geometry, false, data.comments[index].id);
		}
	},
	removeService: function () {
		if (this.serviceLayer.getSource() !== undefined) {
			console.log(this.serviceLayer.getSource());
			this.map.removeLayer(this.serviceLayer);
		}
	},
	loadWms: function (url, layerId) {
		this.removeService();
		Debug.log('Loading WMS ' + url + ' with layer ' + layerId);
		this.serviceLayer.setSource(
			new ol.source.TileWMS({
				url: url,
				params: {
					'LAYERS': layerId,
					'TRANSPARENT': 'true'
				}
			})
		);
	},
	loadWmts: function (url, layerId) {
		this.removeService();
		Debug.log('Loading WMTS ' + url + ' with layer ' + layerId);
		var projection = ol.proj.get(this.getMapCrs());
		var projectionExtent = projection.getExtent();
		var size = ol.extent.getWidth(projectionExtent) / 256;
		var resolutions = new Array(14);
		var matrixIds = new Array(14);
		for (var z = 0; z < 14; ++z) {
			resolutions[z] = size / Math.pow(2, z);
			matrixIds[z] = z;
		}
		this.serviceLayer.setSource(new ol.source.WMTS({
				extent: projectionExtent,
				url: url,
				layer: layerId,
				matrixSet: Mapping.getMapCrs(this.map),
				format: 'image/png',
				projection: projection,
				tileGrid: new ol.tilegrid.WMTS({
					origin: ol.extent.getTopLeft(projectionExtent),
					resolutions: resolutions,
					matrixIds: matrixIds
				}),
				style: 'default'
			})
		);
	},
	getPageTemplate: function () {
		return '/api/internal/doc/showCommentsToGeodata';
	}
});
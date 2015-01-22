/**
 * View for GeodataShow; showing geodata
 * Extend ContentView from the file ApplicationView.js
 */
GeodataShowView = ContentView.extend({
	
	/**
	 * Set the 'el'-property 
	 */
	el: function () {
		return $('#showGeodata');
	},
	
	/**
	 * Return a list of geodata
	 * 
	 * @return {Object} list of geodata
	 * @override getPageContent() from ContentView 
	 */
	getPageContent: function () {
		return this.options.geodata;
	},
	
	/**
	 * Return url for the template of the geodata-list
	 * 
	 * @return {String} url for the template of the geodata-list
	 */
	getPageTemplate: function () {
		return '/api/internal/doc/showGeodataBit';
	}
});



/**
 * View for CommentAddFirstStep
 * Extend ModalView
 */
CommentAddViewStep1 = ModalView.extend({
	
	/**
	 * Return url for the template of the first step to add a comment
	 * 
	 * @return {String} url for the template of the first step to add a comment
	 */
	getPageTemplate: function () {
		return '/api/internal/doc/addCommentFirstStep';
	},
	
	events: {
		"click #addCommentBtn": "createComment"
	},
	
	/**
	 * This function is called when anybody do the first step of adding a comment
	 * Read typed in values for the url an the datatype
	 * Call the method commentAddFirstStepController from the file commentController.js
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
	serviceLayer: null,
	drawType: null,
	
	/**
	 * Return url for the template of the second step to add a comment
	 * 
	 * @return {String} url for the template of the second step to add a comment
	 */
	getPageTemplate: function () {
		return '/api/internal/doc/addCommentSecondStep';
	},
	
	/**
	 * Return the metadata of a geodata
	 * 
	 * @return {Object} metadata of a geodata
	 * @override getPageContent() from ContentView 
	 */
	getPageContent: function () {
		return this.options.metadata;
	},
	
	/**
	 * Called if this view is initialized
	 * If the typed in url undefinded, show a message-box
	 * Else call method render in this class 
	 */
	initialize: function () {
		if (typeof this.options.metadata.url === undefined) {
			MessageBox.addError(Lang.t('failedLoadMeta'));
		}
		else {
			this.render();
		}
	},
	
	/**
	 * Create the formular for the second step in the template
	 * 
	 * @override onLoaded() from ContentView from the file ApplicationView.js 
	 */
	onLoaded: function () {
		// this for the callbacks
		var that = this;

		$('#ratingComment').barrating({showSelectedRating: false});
		if (this.options.layerID) {
			$("#inputLayer option[value='" + this.options.layerID + "']").attr('selected', true);
		}
		$("#inputLayer").on('change', function() {
			that.updateWebserviceLayer($("#inputLayer").val());
		});

		this.featureVector = new ol.source.Vector();
		this.featureVector.on('addfeature', function (event) {
			if (that.feature !== null) {
				that.featureVector.removeFeature(that.feature); // Remove the previous feature
			}
			that.feature = event.feature;
		});

		var bboxLayer = Mapping.getBBoxLayer(Mapping.getBBoxStyle(false));
		this.serviceLayer = new ol.layer.Vector();
		var layers = [this.serviceLayer, bboxLayer, Mapping.getFeatureLayer(this.featureVector)];

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
		this.updateWebserviceLayer(this.options.layerID);

		/**
		 * Let user change the geometry type.
		 * @param {Event} e Change event.
		 */
		$("#geomType").change(function (e) {
			that.addInteraction();
		});

		this.addInteraction();
	},
	
	/**
	 * Load services for the map 
	 */
	updateWebserviceLayer: function(layerId) {
		this.serviceLayer = Mapping.loadWebservice(this.map, this.serviceLayer, this.options.metadata.url, this.options.metadata.metadata.datatype, layerId);
	},
	
	/**
	 * Set the selected draw tpye (Point, LineString, Polygon) 
	 */
	setDrawType: function (type) {
		this.map.removeInteraction(this.draw);
		this.drawType = type;
		this.addInteraction();
	},
	
	/**
	 * Add drawed element to the map (add-comment-map)
	 */
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
	
	/**
	 * Get the geometry of the map
	 * 
	 * @return {Object} geometry if feauter is not null, else return null 
	 */
	getGeometryFromMap: function () {
		if (this.feature !== null) {
			return Mapping.toWkt(this.feature.getGeometry(), this.map);
		}
		else {
			return null;
		}
	},
	
	/**
	 * This function is called when anybody do the second step for adding a comment
	 * Call the method commentAddSecondStepController from the file commentController.js
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
	seviceLayer: null,
	geometryLayer: null,
	bboxLayer: null,
	selectMouseMove: null,
	select: null,
	getPageContent: function () {
		return this.options.geodata;
	},
	
	/**
	 * Handle events to the list of comments to the geodata 
	 */
	onOpened: function () {
		var that = this;

		$('[data-toggle="popover"]').popover({
			html: true
		});
		
		this.bboxLayer = Mapping.getBBoxLayer(Mapping.getBBoxStyle(false));
		this.serviceLayer = new ol.layer.Vector();
		this.geometryLayer = new ol.layer.Vector({
			source: new ol.source.Vector(),
			style: Mapping.getBBoxStyle()
		});
		this.map = new ol.Map({
			layers: Mapping.getBasemps([this.serviceLayer, this.geometryLayer, this.bboxLayer]),
			target: 'commentviewmap',
			controls: Mapping.getControls(),
			view: Mapping.getDefaultView()
		});
		
		//select features and make the features and its comment stand out
		//highlight geometry on mousemouve
		this.selectMouseMove = new ol.interaction.Select({
			condition: ol.events.condition.mouseMove,
			layers: [this.geometryLayer]
		});
		this.map.addInteraction(this.selectMouseMove);
		this.select = new ol.interaction.Select({
			layers: [this.geometryLayer]
		});
		this.map.addInteraction(this.select);
		this.select.getFeatures().on('change:length', function(e) {
			if (e.target.getArray().length === 0) {
			//no features selected
			$('.comment-highlighter').removeClass('comment-highlighter');
			} else {
			// highlight the comments
			$('#CommentId'+e.target.item(0).getId()).addClass('comment-highlighter');
			Debug.log(e.target.item(0).getId());
			}
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
	
	/**
	 * If a certain layer is hidden, remove its bounding box and features from the map (map in comments-to-geodata)
	 * 
 	 * @param {Object} layerId
	 */
	onLayerHidden: function (layerId) {
		Debug.log('Layer ' + layerId + ' hidden');

		// Remove the bbox from the map
		this.bboxLayer.getSource().clear();

		// Remove features from map
		this.geometryLayer.getSource().clear();
		this.select.getFeatures().clear();
		this.selectMouseMove.getFeatures().clear();
		
	},
	
	/**
	 * Handle events if a certain layer is shown on map (map in comments-to-geodata)
	 * 
	 * @param {Object} layerId
	 */
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
	
	/**
	 * Add bounding boxes and features of a layer to the map (map in comments-to-geodata)
	 * 
 	 * @param {Object} data
	 */
	fillLayer: function (data) {
		// Get the bbox from the layer or as fallback from the global dataset
		var bbox = data.bbox ? data.bbox : this.options.geodata.metadata.bbox;
		// Add bbox extent and fit it into the window
		if (bbox) {
			Mapping.addWktToLayer(this.map, this.bboxLayer, bbox, true);
		}

		//Add features to map
		for (var index = 0; index < data.comments.length; index++){
			Mapping.addWktToLayer(this.map, this.geometryLayer, data.comments[index].geometry, false, data.comments[index].id);
		}
		
		// Load WMS/WMTS data
		this.serviceLayer = Mapping.loadWebservice(this.map, this.serviceLayer, this.options.geodata.url, this.options.geodata.metadata.datatype, data.id);
	},
	
	/**
	 * Return url for the template of the detail-site with comments to a geodata
	 * 
	 * @return {String} url for the template of the detail-site with comments to a geodata
	 */
	getPageTemplate: function () {
		return '/api/internal/doc/showCommentsToGeodata';
	}
});
/**
 * View for GeodataShow; showing geodata
 * Extend ContentView
 */
GeodataShowView = ContentView.extend({
	
	el: function() {
		return $('#showGeodata');
	},

	getPageContent: function() {
		return this.options.geodata; 
	},

	getPageTemplate: function() {
		return '/api/internal/doc/showGeodataBit';
	}
});



/**
 * View for CommentAddFirstStep
 * Extend ModalView
 */
CommentAddViewStep1 = ModalView.extend({ 

	getPageTemplate: function() {
		return '/api/internal/doc/addCommentFirstStep';
	},
    
    events: {
    	"click #addCommentBtn": "createComment"
    },

	/*
	 * This function is called when anybody creates a comment
	 */
	createComment: function(event) {
		Debug.log('Try to get metadata');
				
		// Creates primary details of a comment with typed in values
		var details = {
			"url" : $("#inputURL").val(),
			"datatype" : $("#inputDataType").val()
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
	source: null,
	feature: null,

	getPageTemplate: function() {
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
	
	onLoaded: function() {
		
        $('#ratingComment').barrating({ showSelectedRating:false });
		$("#inputDataType option[value='"+this.options.metadata.datatype+"']").attr('selected',true);
		
		// this for the callbacks
		var that = this;
		
		var raster = new ol.layer.Tile({
			source: new ol.source.OSM(),
		});
		
		this.source = new ol.source.Vector();
		
		this.source.on('addfeature', function(event) {
			if (that.feature !== null) {
				that.source.removeFeature(that.feature); // Remove the previous feature
			}
			that.feature = event.feature;
		});
		
		var polySource = new ol.source.Vector();
		
		// set the style of the vector geometries
		var polyStyle = new ol.style.Style({
			stroke: new ol.style.Stroke({
				color: 'rgba(0,139,0,1)',
				width: 2
			})
		});
		
		var vectorlayer = new ol.layer.Vector({
			source: polySource,
			style: polyStyle
		});
		
		var vector = new ol.layer.Vector({
		  source: this.source,
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
		  layers: [raster, vector, vectorlayer],
		  target: 'mapAddComm',
		  view: view
		});
		
		if (this.options.metadata.metadata.bbox) {
			// Parse the bbox
			var parser = new ol.format.WKT();
			var geom = parser.readGeometry(this.options.metadata.metadata.bbox);
			geom.transform(this.getServerCrs(), this.getMapCrs());
			/*
			vectorlayer.addFeature(new ol.Feature({
				geometry: geom,
				projection: this.getMapCrs()
			}));*/
			// fit the extent to the given bbox
			view.fitExtent(geom.getExtent(), this.map.getSize());
			polySource.addFeature(new ol.Feature({
				geometry: geom,
				projection: this.getMapCrs()
			}));
		}
		
		/**
		 * Let user change the geometry type.
		 * @param {Event} e Change event.
		 */
		$("#geomType").change( function(e) {
			that.map.removeInteraction(that.draw);
		  	that.addInteraction();
		});

		this.addInteraction();
	},
	
	addInteraction: function () {
		var value = $("#geomType").val();
			if (value !== 'None') {
		  		this.draw = new ol.interaction.Draw({
		    		source: this.source,
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
	/*
	 * calculates the current bounding box of the map and returns it as an WKt String
	 */
	getBoundingBox: function () {
		var mapbbox = this.map.getView().calculateExtent(this.map.getSize());
		var geom = new ol.geom.Polygon([[new ol.extent.getBottomLeft(mapbbox), new ol.extent.getBottomRight(mapbbox), new ol.extent.getTopRight(mapbbox), new ol.extent.getTopLeft(mapbbox), new ol.extent.getBottomLeft(mapbbox)]]);
		geom.transform(this.getMapCrs(), this.getServerCrs());
		return this.parser.writeGeometry(geom);
	},
	/*
	 * add the bboxes from the Geodata to the map
	 */
	addGeodataToMap: function (data) {
		var polygeom;
		// gets each bbox(wkt format), transforms it into a geometry and adds it to the vector source 
		for (var index = 0; index < data.geodata.length; index++) {
			polygeom = this.parser.readGeometry(data.geodata[index].metadata.bbox, this.getServerCrs());
			polygeom.transform(this.getServerCrs(), this.getMapCrs());
			this.polySource.addFeature(new ol.Feature({
				geometry: new ol.geom.Polygon(polygeom.getCoordinates()),
				projection: this.getMapCrs()
			}));
		}
	},
    
    events: {
    	"click #addCommentSecondBtn": "createComment"
    },
	
	getGeometryFromMap: function() {
		// TODO: Get the geometry the user created from the map
		return null;
	},

	/*
	 * This function is called when anybody creates a comment
	 */
	createComment: function(event) {
		Debug.log('Try to add comment');
				
		// Creates further details of a comment with typed in values
		var details = {
			"url" : $("#inputURL").val(),
			"datatype" : $("#inputDataType").val(),
			"layer" : $("#inputLayer").val(),
			"text" : $("#inputText").val(),
			"geometry" : this.getGeometryFromMap(),
			"start": $("#inputStartDate").val(),
			"end": $("#inputEndDate").val(),		
			"rating": $("#ratingComment").val(),
			"title" : $("#inputTitle").val()
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

	getPageContent: function() {
		return this.options.geodata; 
	},
	
	onOpened: function() {
		$('[data-toggle="popover"]').popover({
			html: true
		});
	},

	getPageTemplate: function() {
		return '/api/internal/doc/showCommentsToGeodata';
	}
});
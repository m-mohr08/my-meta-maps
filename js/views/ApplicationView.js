ContentView = Backbone.View.extend({
	el: $('#content'),
	templateCache: [],
	constructor: function (options) {
		this.configure(options || {});
		Backbone.View.prototype.constructor.apply(this, arguments);
	},
	configure: function (options) {
		if (this.options) {
			options = _.extend({}, _.result(this, 'options'), options);
		}
		this.options = options;
	},
	initialize: function () {
		this.render();
	},
	onLoaded: function () {
	},
	loadTemplate: function (url, callback) {
		if (typeof (this.templateCache[url]) == 'string') {
			callback(this.templateCache[url]);
		}
		else {
		var that = this;
			$.get(url, function(data) {
				that.templateCache[url] = data;
				callback(data);
			}, 'html');
		}
		
	},
	render: function () {
		var that = this;
		this.loadTemplate(this.getPageTemplate(), function (data) {
			template = _.template(data);
			var vars = {
				data: that.getPageContent(),
				config: config,
				ViewUtils: ViewUtils
			};
			that.$el.html(template(vars));
			that.onLoaded();
		});
	},
	getPageTemplate: function () {
		Debug.log('Error: Called abstract method!');
		return null;
	},
	close: function () {
		this.$el.html(''); // Remove content from page
		// Remove callbacks, events, listeners etc.
		this.stopListening();
		this.undelegateEvents();
		this.unbind();
		this.off();
//		this.remove(); // Remove view from DOM
//		Backbone.View.prototype.remove.call(this);
	},
	getPageContent: function () {
		return {};
	}
});
// Statics
ContentView.active = null;
ContentView.register = function (view) {
	if (ContentView.active !== null) {
		ContentView.active.close();
		ContentView.active = null;
	}
	ContentView.active = view;
};

ModalView = ContentView.extend({
	el: $('#modal'),
	// Called after modal is loaded (and not opened yet)
	onLoaded: function () {
		this.modal();
		this.showProgress();
		this.onOpened();
	},
	// Called after modal is opened
	onOpened: function () {

	},
	modal: function () {
		$('#modal').find('.modal').modal('show');
	},
	showProgress: function () {
		Progress.show('.modal-progress');
	}
});

MapView = ContentView.extend({
	// OpenLayers/Map
	map: null,
	polySource: new ol.source.Vector(),
	vectorlayer: null,
	parser: new ol.format.WKT(),
	mapSearchExecuted: true,
	// Default options for filters
	options: {
		searchHash: null,
        q: '',
        bbox: null,
        radius: null,
        minrating: null,
        metadata: false,
        time: {
            start: '',
            end: ''
        }
	},
	
	onLoaded: function () {
		// this for the callbacks
		var that = this;
		
		var view = new ol.View({
			center: [0, 0],
			zoom: 2
		});
		// When the map view changes we need to search again
		view.on('change:center', function() { that.onExtentChanged() });
		view.on('change:resolution', function() { that.onExtentChanged() });
		view.on('change:rotation', function() { that.onExtentChanged() });

		// set the style of the vector geometries
		var polyStyle = new ol.style.Style({
			fill: new ol.style.Fill({
				color: 'rgba(0,139,0,0.1)'
			}),
			stroke: new ol.style.Stroke({
				color: 'rgba(0,139,0,1)',
				width: 2
			})
		});
		
		this.vectorlayer = new ol.layer.Vector({
			source: this.polySource,
			style: polyStyle
		});

		this.map = new ol.Map({
			layers: [
				new ol.layer.Tile({
					source: new ol.source.OSM()
				}),
				this.vectorlayer
			],
			target: 'map',
			controls: ol.control.defaults({
				attributionOptions: /** @type {olx.control.AttributionOptions} */({
					collapsible: false
				})
			}),
			view: view
		});

		// The basic page is now loaded. Now we set the default data depending on the context.
		if (this.options.searchHash) {
			// We have a search permalink and need to get the stored parameters.
			var model = new PermalinkLoad();
			model.id = this.options.searchHash;
			model.fetch({
				before: function() {
					Progress.start('.filter-progress');
				},
				success: function(model, response) {
					Progress.stop('.filter-progress');
					that.inititlizeData(response.permalink);
				},
				error: function() {
					Progress.stop('.filter-progress');
					MessageBox.addError('Die Parameter der Suche konnten leider nicht geladen werden.');
					that.inititlizeData();
				}
			});
		}
		else {
			// Default map view without any preset filters.
			this.inititlizeData();
		}
	},
	inititlizeData: function(params) {
		// Override the given params in this.options
		this.configure(params);
		
		// Set the keywords
		$('#SearchTerms').val(this.options.q);

		// Set the bbox
		var view = this.map.getView();
		if (this.options.bbox) {
			// fit the extent to the given bbox
			var geom = this.parser.readGeometry(this.options.bbox);
			geom.transform(this.getServerCrs(), this.getMapCrs());
			view.fitExtent(geom.getExtent(), this.map.getSize());
		}
		else {
			// gets the geolocation
			var geolocation = new ol.Geolocation({
				projection: view.getProjection(),
				tracking: true
			});
			// zooms the map to the users location
			geolocation.once('change:position', function () {
				view.setCenter(geolocation.getPosition());
				view.setZoom(5);
			});
		}

		// Check the "Include metadata" checkbox
		$('#includeMetadata').prop('checked', this.options.metadata);


		// Set the start and end time
		this.updateDatePicker("#filterStartTime", this.options.time.start);
		this.updateDatePicker("#filterEndTime", this.options.time.end);

		// Set the radius und rating
		$('#spatialFilter').barrating({
			initialRating: this.options.radius,
			showValues: true,
			showSelectedRating: false,
			onSelect: executeSearch,
			onClear: executeSearch
		});
		$('#ratingFilter').barrating({
			initialRating: this.options.minrating,
			showSelectedRating: false,
			onSelect: executeSearch,
			onClear: executeSearch
		});

		// Execute the search
		this.doSearch();
	},
	updateDatePicker: function(selector, dateIso) {
		if (_.isEmpty(dateIso)) {
			return;
		}
		var regexp = /^(\d{4})-(\d\d)-(\d\d)/g;
		var matches = regexp.exec(dateIso);
		if (matches) {
			var value = config.datepicker.format;
			value = value.replace(/yy(yy)?/i, matches[1]);
			value = value.replace(/m(m)?/i, matches[2]);
			value = value.replace(/d(d)?/i, matches[3]);
			$(selector).val(value);
		}
	},
	onExtentChanged: function() {
		// When multiple events occur in a certain time span (500ms) then only search once.
		this.mapSearchExecuted = false;
		var that = this;
		window.setTimeout(function() {
			if (!that.mapSearchExecuted) {
				executeSearch();
				that.mapSearchExecuted = true;
			}
		}, 500);
	},
	doSearch: function () {
		var that = this;
		geodataShowController({
			before: function () {
				Progress.start('.geodata-progress');
				that.polySource.clear();
			},
			success: function (model, response) {
				new GeodataShowView(response);
				Progress.stop('.geodata-progress');
				that.addGeodataToMap(response);
			},
			error: function (model, response) {
				MessageBox.addError('Die Geodaten konnten nicht geladen werden.');
				Progress.stop('.geodata-progress');
			},
			skipped: function () {
				Progress.stop('.geodata-progress');
			}
		});
	},
	resetSearch: function (form) {
		form.reset();
		// Remove visible feedback of barrating.
		$('#spatialFilter').barrating('clear');
		$('#ratingFilter').barrating('clear');
		this.doSearch();
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
	getPageTemplate: function () {
		return '/api/internal/doc/map';
	}

});

AboutView = ContentView.extend({
	getPageTemplate: function () {
		return 'api/internal/doc/about';
	}
});

HelpView = ContentView.extend({
	getPageTemplate: function () {
		return 'api/internal/doc/help';
	}
});
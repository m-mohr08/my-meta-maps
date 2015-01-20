/**
 * View for whole content 
 * All views that extend this view, will shown in this view
 */
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
	noCache: function(url) {
		return false;
	},
	loadTemplate: function (url, callback) {
		if (typeof (this.templateCache[url]) == 'string' && !this.noCache(url)) {
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
		// Normally we should remove the content from the DOM, but this is delayed for some reasons
		// and destroys our cached and "fast" templates. Therefore we skip this as the DOM node 
		// content is replaced anyway.
//		this.$el.html('');

		// Remove callbacks, events, listeners etc.
		this.stopListening();
		this.undelegateEvents();
		this.unbind();
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
	}
	ContentView.active = view;
};

/**
 * View for modals
 * Extend ContentView
 * All views that extend this view, will shown in this view
 */
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

/**
 * View for the map, the filters and the list of geodata 
 */
MapView = ContentView.extend({
	// OpenLayers/Map
	map: null,
	polyLayer: null,
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
		
		var view = Mapping.getDefaultView();
		// When the map view changes we need to search again
		view.on('change:center', function() { that.onExtentChanged(); });
		view.on('change:resolution', function() { that.onExtentChanged(); });
		view.on('change:rotation', function() { that.onExtentChanged(); });

		// Layer with the bounding boxes
		this.polyLayer = Mapping.getBBoxLayer(Mapping.getBBoxStyle(true));

		this.map = new ol.Map({
			layers: Mapping.getBasemps([this.polyLayer]),
			target: 'map',
			controls: Mapping.getControls(),
			view: view
		});
		
		//highlight geometry on mousemouve
		var selectMouseMove = new ol.interaction.Select({
			condition: ol.events.condition.mouseMove
		});
		this.map.addInteraction(selectMouseMove);
		// select geometry on mouseclick and open CommentView
		var select = new ol.interaction.Select({
			style: Mapping.getBBoxStyle(true)
		});
		this.map.addInteraction(select);
		select.getFeatures().on('change:length', function(e) {
			if (e.target.getArray().length === 0) {
			//no features selected
			} else {
			//open CommentView of the feature
			 router.geodata(e.target.item(0).getId());
			}
		});
		//select more than one feature
		
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
			var geom = Mapping.fromWkt(this.options.bbox, this.map);
			if (geom) {
				view.fitExtent(geom.getExtent(), this.map.getSize());
			}
		}
		else {
			Mapping.geolocate(view);
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
	/*
	 * calculates the current bounding box of the map and returns it as an WKt String
	 */
	getBoundingBox: function () {
		var mapbbox = this.map.getView().calculateExtent(this.map.getSize());
		var geom = new ol.geom.Polygon([[new ol.extent.getBottomLeft(mapbbox), new ol.extent.getBottomRight(mapbbox), new ol.extent.getTopRight(mapbbox), new ol.extent.getTopLeft(mapbbox), new ol.extent.getBottomLeft(mapbbox)]]);
		return Mapping.toWkt(geom, this.map);
	},
	/*
	 * add the bboxes from the Geodata to the map
	 */
	addGeodataToMap: function (data) {
		this.polyLayer.getSource().clear();
		// gets each bbox(wkt format), transforms it into a geometry and adds it to the vector source 
		for (var index = 0; index < data.geodata.length; index++) {
			Mapping.addWktToLayer(this.map, this.polyLayer, data.geodata[index].metadata.bbox, false, data.geodata[index].id);
		}
	},
	getPageTemplate: function () {
		return '/api/internal/doc/map';
	}

});

/**
 * View for imprint site
 * Extend ContentView
 */
AboutView = ContentView.extend({
	getPageTemplate: function () {
		return 'api/internal/doc/about';
	}
});

/**
 * View for help site 
 * Extend ContentView
 */
HelpView = ContentView.extend({
	getPageTemplate: function () {
		return 'api/internal/doc/help';
	}
});
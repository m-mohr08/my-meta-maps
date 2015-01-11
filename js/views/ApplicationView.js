ContentView = Backbone.View.extend({
	el: $('#content'),
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
	render: function () {
		var that = this;
		$.get(this.getPageTemplate(), function (data) {
			template = _.template(data);
			that.$el.html(template({data: that.getPageContent()}));
			that.onLoaded();
		}, 'html');
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
	onLoaded: function () {
		$('#modal').find('.modal').modal('show');
	}
});

MapView = ContentView.extend({
	map: null,
	onLoaded: function () {
		var view = new ol.View({
                        //projection: 'EPSG: 4326',
			center: [0, 0],
			zoom: 2
		});

		this.map = new ol.Map({
			layers: [new ol.layer.Tile({
					source: new ol.source.OSM()
				})
                            ],
			target: 'map',
			controls: ol.control.defaults({
				attributionOptions: /** @type {olx.control.AttributionOptions} */({
					collapsible: false
				})
			}),
			view: view
		});
                console.log("show map");

		// gets the geolocation
		var geolocation = new ol.Geolocation({
			projection: view.getProjection(),
			tracking: true
		});
		// zooms the map to the users location
		geolocation.once('change:position', function () {
			view.setCenter(geolocation.getPosition());
			view.setZoom(10);
		});

		$('#spatialFilter').barrating({
			showValues: true,
			showSelectedRating: false,
			onSelect: executeSearch,
			onClear: executeSearch
		});
		$('#ratingFilter').barrating({
			showSelectedRating: false,
			onSelect: executeSearch,
			onClear: executeSearch
		});

		this.doSearch();
	},
	doSearch: function() {
		commentsShowController(new CommentsShow(), this);
	},
	resetSearch: function(form) {
		form.reset();
		// Remove visible feedback of barrating.
		$('#spatialFilter').barrating('clear');
		$('#ratingFilter').barrating('clear');
		this.doSearch();
	},
	getBoundingBox: function() {
		// TODO: Return the current bounding box of the map
		return null;
	},
        
	addGeodataToMap: function (data) {
            console.log("addGeodataToMap started");
            
                // get all the bboxes from the comments into one array
                var parser = new ol.format.WKT({
                    splitCollection: false
                });
                var polySource = new ol.source.Vector();
                var polygeom;
                for(var index = 0; index < data.geodata.length; index++) {
                    console.log(data.geodata[index].metadata.bbox);
                    polygeom = parser.readGeometry(data.geodata[index].metadata.bbox, "EPSG:4326");
                    console.log(polygeom.getCoordinates());
                    polySource.addFeature(new ol.Feature({
                        geometry: polygeom,
                        projection: "EPSG:4326"
                        })
                    );
                }
                
                var polyStyle = new ol.style.Style({
                    fill: new ol.style.Fill({
                        color: '#F1EDED'
                    }),
                    stroke: new ol.style.Stroke({
                        color: '#000000',
                        width: 10
                    })
                });
                
                // show the bboxes in the map
                this.map.addLayer(new ol.layer.Vector({
                    source: polySource,
                    style: polyStyle,
                    visible: true
                    })
                );
                
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
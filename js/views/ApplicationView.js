ContentView = Backbone.View.extend({
    el: $('#content'),
    initialize: function () {
        this.render();
    },
    onLoaded: function () {

    },
    render: function () {
        var that = this;
        $.get(this.getPageTemplate(), function (data) {
            template = _.template(data, {});
            that.$el.html(template);
            that.onLoaded();
        }, 'html');
    },
    getPageTemplate: function () {
        console.log('Error: Called abstract method!');
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
    }

});

ModalView = ContentView.extend({
    el: $('#modal'),
    onLoaded: function () {
        $('#modal').find('.modal').modal('show');
    }

});

MapView = ContentView.extend({
    onLoaded: function () {
        var view = new ol.View({
            //projection: "EPSG: 4326",
            center: [0, 0],
            zoom: 2
        });

<<<<<<< HEAD
        var map = new ol.Map({
            layers: [new ol.layer.Tile({
                    source: new ol.source.OSM()
                })],
            target: 'map',
            controls: ol.control.defaults({
                attributionOptions: /** @type {olx.control.AttributionOptions} */({
                    collapsible: false
                })
            }),
            view: view

        });
        
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

        $('#spatialFilter').barrating('show', {showValues: true, showSelectedRating: false});
        $('#ratingFilter').barrating({showSelectedRating: false});

    },
    getPageTemplate: function () {
        return '/js/templates/mapTemplate.html';
    }
=======
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
           	
    	$('#spatialFilter').barrating('show', { showValues:true, showSelectedRating:false });
        $('#ratingFilter').barrating({ showSelectedRating:false });
		
	},
	
	getPageTemplate: function() {
		return '/api/internal/doc/map';
	}
>>>>>>> 34bb5fe8807c17b3014fadb7049c18a15ca80aad
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

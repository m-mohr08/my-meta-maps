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
   },
    getPageContent: function () {

        return {};
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
            center: [0, 0],
            zoom: 2
        });

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

        commentsShowController(new CommentsShow());

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
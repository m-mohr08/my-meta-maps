/**
 * Class for Logging
 */
Debug = {
	/**
	 * Logs a message for debugging purposes. 
	 * 
	 * Logging is only active when debug mode is activated in config files.
	 * 
	 * @param {String} message
	 */
	log: function(message) {
		if (config.debug) {
			console.log(message);
		}
	}
};

Utils = {
	viaProxy: function(url) {
		return '/proxy?url=' + encodeURI(url);
	}
};

/**
 * Class for all the base Functions to create, manage and work on the Map
 */
Mapping = {
	
	wkt: new ol.format.WKT(),
	
	/*+
	 * Function to get the Projection from the Data
	 * @returns {String} Projection
	 */
	getServerCrs: function () {
		return 'EPSG:4326';
	},
	
	/**
	 * Function to get the Projection of the Map
	 * @param {ol.Map} map
	 * @returns {String} Projection
	 */
	getMapCrs: function (map) {
		// ToDo: Get the real projection from the map object
		return 'EPSG:3857';
	},
	
	/**
	 * tracks the Geolocation from the user and sets it as center of the map
	 * @param {ol.View} view of the map
	 */
	geolocate: function(view) {
		// gets the geolocation
		var geolocation = new ol.Geolocation({
			projection: view.getProjection(),
			tracking: true
		});
		// zooms the map to the users location
		geolocation.once('change:position', function () {
			view.setCenter(geolocation.getPosition());
			view.setZoom(7);
		});	
	},
	
	/**
	 * transforms the Geometry from an wkt object to a ol.geom.Geometry
	 * @param {type} wkt format
	 * @param {type} map
	 * @returns {ol.geom.Geometry} Geometry
	 */
	fromWkt: function(wkt, map) {
		var geom = Mapping.wkt.readGeometry(wkt);
		if (geom) {
			geom.transform(Mapping.getServerCrs(), Mapping.getMapCrs(map));
		}
		return geom;
	},

	/**
	 * transforms the Geometry from a ol.geom.Geometry to an wkt object
	 * @param {ol.geom.Geometry} geom
	 * @param {ol.Map} map
	 * @returns {String} wkt
	 */
	toWkt: function(geom, map) {
		geom.transform(Mapping.getMapCrs(map), Mapping.getServerCrs());
		return Mapping.wkt.writeGeometry(geom);
	},
	
	/**
	 * creates the Layer of the map
	 * @param {Array| <ol.layer>} Layers
	 * @returns {Array| <ol.layer>} Layers of the map
	 */
	getBasemps: function(layers){
		var basemaps = [
			new ol.layer.Group({
				title: 'Basemaps', // TODO: Language
				layers: [
					// OSM
					new ol.layer.Tile({
						title: 'OpenStreetMap',
						type: 'base',
						visible: true,
						source: new ol.source.OSM()
					})
					// TODO: Add Bing
				]
			})
		];
		//join the layers to the basemap
		if (layers) {
			var overlays = new ol.layer.Group({
				title: 'Overlays', // TODO: Language
				layers: layers
			});
			basemaps.push(overlays);
		}
		return basemaps;
	},
	
	/**
	 * get the default View
	 * @returns {ol.View} View
	 */
	getDefaultView: function() {
		return new ol.View({
			center: [0, 0],
			zoom: 2
		});
	},
	
	/**
	 * Get the Control Parameter of the Map
	 * @param {ol.control} controls
	 * @returns {ol.control.defaults} Controls of the map
	 */
	getControls: function(controls) {
		if (!controls) {
			controls = [];
		}
		
		var layerSwitcher = new ol.control.LayerSwitcher();
		controls.push(layerSwitcher);
		return ol.control.defaults({
			attributionOptions: /** @type {olx.control.AttributionOptions} */({
				collapsible: false
			})
		}).extend(controls);
	},
	
	/**
	 * get a new Vector Layer with the drawn features
	 * @param {ol.source} source
	 * @returns {ol.layer.Vector} Vector Layer with features
	 */
	getFeatureLayer: function(source) {
		return new ol.layer.Vector({
			title: 'User defined geometries', // TODO: Language
			source: source,
			style: Mapping.getFeatureStyle()
		});
	},
	
	/**
	 * get the Style of the drawn features
	 * @returns {ol.style.Style} Style
	 */
	getFeatureStyle: function() {
		return new ol.style.Style({
			fill: new ol.style.Fill({
				color: 'rgba(255, 255, 255, 0.2)'
			}),
			stroke: new ol.style.Stroke({
				color: '#d9534f',
				width: 2
			}),
			image: new ol.style.Circle({
				radius: 7,
				fill: new ol.style.Fill({
					color: '#d9534f'
				})
			})
		});
	},
	
	/**
	 * Returns a Vector Layer and if the source is given, add the BBox Feature to the Layer
	 * @param {ol.style} style of the BBoxes
	 * @param {ol.source} source of the BBoxes
	 * @returns {ol.layer.Vector} Layer
	 */
	getBBoxLayer: function(style, source) {
		if (!source) {
			source = new ol.source.Vector();
		}
		return new ol.layer.Vector({
			source: source,
			style: style
		});
	},
	
	/**
	 * Returns the BBox Style and if the Boolean fill is true, add a transparent filling to the style
	 * @param {Boolean} fill
	 * @returns {ol.style.Style} Style
	 */
	getBBoxStyle: function(fill) {
		var style = {
			stroke: new ol.style.Stroke({
				color: 'rgba(0,139,0,1)',
				width: 2
			})
		};
		// Add transparent filling if requested
		if (fill) {
			style.fill = new ol.style.Fill({
				color: 'rgba(0,139,0,0.1)'
			});
		}
		return new ol.style.Style(style);
	},
	
	/**
	 * Adds the wkt Features as an ol.geom.Geometry to the source of the Layer, if fitExtent is true, the map is fitted to the Extent of Geometry
	 * @param {ol.Map} map
	 * @param {ol.layer} layer
	 * @param {String} wkt
	 * @param {Boolean} fitExtent
	 * @param {int} idgeofeature
	 * @returns {undefined}
	 */
	addWktToLayer: function(map, layer, wkt, fitExtent, idgeofeature) {
		if (!map || !layer || !wkt ) {
			return;
		}
		var geom = Mapping.fromWkt(wkt, map);
		if (geom) {
			if (fitExtent) {
				map.getView().fitExtent(geom.getExtent(), map.getSize());
			}
			var feature = new ol.Feature({
				geometry: geom,
				projection: Mapping.getMapCrs(map)
			});
			feature.setId(idgeofeature);
			layer.getSource().addFeature(feature);
		}
	},
	
	/**
	 * Creates and Returns the Controls(Buttons etc) for the addCommentSecondStep Map
	 * @param {String} content
	 * @param {String} title
	 * @param {String} className
	 * @param {type} callback
	 * @returns {ol.control.Control}
	 */
	createCustomControl: function(content, title, className, callback) {
		var customControl = function (opt_options) {
			var options = opt_options || {};

			var callbackWrapper = function(e) {
				e.preventDefault(); // Prevent the anchor href getting called
				callback(e);
			};

			var button = document.createElement('button');
			button.title = title;
			button.innerHTML = content;
			button.addEventListener('click', callbackWrapper, false);
//			button.addEventListener('touchstart', callbackWrapper, false);

			var element = document.createElement('div');
			element.className = className + ' ol-control ol-custom-control ol-unselectable';
			element.title = title;
			element.appendChild(button);

			ol.control.Control.call(this, {
				element: element,
				target: options.target
			});
		};
		ol.inherits(customControl, ol.control.Control);
		return new customControl();
	},
	/**
	 * Calls the external services for layers/data to be shown for the given url and datatype.
	 * 
	 * Currently supported are WMS, WMTS, KML.
	 * 
	 * @param {ol.Map} map
	 * @param {ol.layer} mapLayer
	 * @param {String} url
	 * @param {String} datatype
	 * @param {int} layerId
	 * @returns {ol.layer} Layer
	 */
	loadWebservice: function (map, mapLayer, url, datatype, layerId) {
		Debug.log('Loading webservice from ' + url + ' as ' + datatype + ' using layer ' + layerId);
		var newLayer = null;
		switch(datatype) {
			case 'wms':
				newLayer = Mapping.loadWms(url, layerId);
				break;
			case 'wmts':
				newLayer = Mapping.loadWmts(url, layerId, Mapping.getMapCrs(map));
				break;
			case 'kml':
				newLayer = Mapping.loadKml(url, Mapping.getMapCrs(map));
				break;
		}

		// Create empty layer as placeholder if no other layer should be set
		if (newLayer === null) {
			newLayer = new ol.layer.Vector();
			newLayer.setVisible(false);
		}
		else {
			newLayer.setVisible(true);
		}

		// Find the old layer in the hierarchy of layers and replace it with the new layer.
		$.each(map.getLayers().getArray(), function (k, v) {
			if (v.getLayers) {
				$.each(v.getLayers().getArray(), function (k2, v2) {
					if (mapLayer === v2) {
						v.getLayers().setAt(k2, newLayer);
					}
				});
			}
			else if (mapLayer === v) {
				map.getLayers().setAt(k, newLayer);
			}
		});

		return newLayer;
	},
	/**
	 * Creates and Returns a KML Layer with a given URL.
	 * @param {string} url
	 * @param {string} projection
	 * @returns {ol.layer.Vector}
	 */
	loadKml: function(url, projection) {
		return new ol.layer.Vector({
			source: new ol.source.KML({
				projection: projection,
				url: Utils.viaProxy(url)
			})
		});
	},
	/**
	 * Creates and Returns a WMS Layer with a given URL
	 * @param {string} url
	 * @param {int} layerId
	 * @returns {ol.layer.Tile}
	 */
	loadWms: function (url, layerId) {
		if (_.isEmpty(layerId)) {
			return null;
		}
		return new ol.layer.Tile({
			source: new ol.source.TileWMS({
				title: 'WMS',
				url: url,
				params: {
					LAYERS: layerId,
					TRANSPARENT: 'true'
				}
			})
		});
	},
	
	/**
	 * Creates and Returns a Layer with a WMTS source with a given URL
	 * @param {String} url
	 * @param {int} layerId
	 * @param {String} projection
	 * @returns {ol.layer.Tile}
	 */
	loadWmts: function (url, layerId, projection) {
		if (_.isEmpty(layerId)) {
			return null;
		}
		var projectionExtent = projection.getExtent();
		var size = ol.extent.getWidth(projectionExtent) / 256;
		var resolutions = new Array(14);
		var matrixIds = new Array(14);
		for (var z = 0; z < 14; ++z) {
			resolutions[z] = size / Math.pow(2, z);
			matrixIds[z] = z;
		}
		return new ol.layer.Tile({
			source: new ol.source.WMTS({
				title: 'WMTS',
				extent: projectionExtent,
				url: url,
				layer: layerId,
				matrixSet: projection.getCode(),
				format: 'image/png', // TODO: Determine which format is supported by the server...
				projection: projection,
				tileGrid: new ol.tilegrid.WMTS({
					origin: ol.extent.getTopLeft(projectionExtent),
					resolutions: resolutions,
					matrixIds: matrixIds
				}),
				style: 'default'
			})
		});
	}
};

Progress = {
	
	show: function(id) {
		// This progress bar style doesn't need a show
	},
	
	hide: function(id) {
		$(id).html('');
	},
	
	start: function(id) {
		var html = '<img src="/img/loading.gif" alt="Loading data..." title="Loading data..." />'; // TODO: Language
		$(id).html(html);
	},
	
	stop: function(id) {
		Progress.hide(id);
	}
	
};

/**
 * Class to handle submissions form a user in a form 
 */
FormErrorMessages = {

	errorClass: 'invalid',
	successClass: 'success',
	
	applyPartially: function(form, json, success) {
		var that = this;
		$.each(json, function(field, message) {
			var elm = $(form).find("*[name='" + field + "']").parent(".form-group");
			elm.addClass(success ? that.successClass : that.errorClass);
			elm.find('.error-message').text(message);
		});
	},
	
	apply: function(form, json, success) {
		this.remove(form);
		this.applyPartially(form, json, success);
	},
	
	remove: function(form) {
		$(form).find("." + this.errorClass).removeClass(this.errorClass);
		$(form).find("." + this.successClass).removeClass(this.successClass);
	}
	
};

/**
 * Class for logged in user 
 */
AuthUser = {
	
	loggedIn: false,
	
	init: function() {
		var accountArea = $('#userAccountName');
		var id = accountArea.attr('data-id');
		accountArea.removeAttr('data-id');
		var user = (id && id > 0) ? accountArea.text() : null;
		this.setUser(user);
	},

	setUser: function(name) {
		this.loggedIn = (name && name.length > 0);

		// Modify register button
		$('#registerBtn').css('display', this.loggedIn ? 'none' : 'block');

		// Modify account button
		var accountBtn = $('#userAccountBtn');
		accountBtn.removeClass('disabled');
		if (!this.loggedIn) {
			accountBtn.addClass('disabled');
		}
		$('#userAccountName').text(this.loggedIn ? name : 'Gast');
		
		// Modify login account
		var loginIcon = $('#loginBtnIcon');
		loginIcon.removeClass('glyphicon-log-in');
		loginIcon.removeClass('glyphicon-log-out');
		loginIcon.addClass(this.loggedIn ? 'glyphicon-log-out' : 'glyphicon-log-in');
		$('#logBtnText').text(this.loggedIn ? 'Abmelden' : 'Anmelden');
		var loginBtn = $('#loginBtn');
		loginBtn.removeClass('btn-danger');
		loginBtn.removeClass('btn-primary');
		loginBtn.addClass(this.loggedIn ? 'btn-danger' : 'btn-primary');
	}
	
};

/**
 * Class to handle alerts for user-iteractions 
 */
MessageBox = {

	dismissPermanently: function(name) {
		Debug.log("Dismissing message: " + name);
		// Remove message box
		$('#' + name).remove();
		// Cookie with the specified name contains a 1 to signal it should be hidden permanently
		document.cookie = escape(name) + "=1; expires=Mon, 30 Dec 2030 00:00:00 GMT; path=/";
	},
	
	addError: function(message, title) {
		this.add(message, 'danger', title);
	},
	
	addSuccess: function(message, title) {
		this.add(message, 'success', title);
	},
	
	addWarning: function(message, title) {
		this.add(message, 'warning', title);
	},
	
	addInfo: function(message, title) {
		this.add(message, 'info', title);
	},
	
	add: function (message, className, title) {
		var html = '<div class="alert alert-' + className + ' alert-dismissible">';
		html += '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">' + Lang.t('close') + '</span></button>';
		if (title) {
			html += '<strong>' + title + '</strong><hr>';
		}
		html += message + '</div>';
		var element = $().add(html);
		$('#messages').append(element);
		element.delay(10000).fadeOut(2000);
	}
	
};

/**
 * Class to handle the language phrases.
 * 
 * This code bases on an implementation from https://github.com/andywer/laravel-js-localization !
 * The code is released under the MIT license.
 * 
 * @author Andy Wermke, https://github.com/andywer/laravel-js-localization
 */
Lang = {
	
	/*
	 * Translate a message.
	 *
	 * @method get
	 * @static
	 * @param {String} messageKey       The message key (message identifier).
	 * @param {Object} [replacements]   Associative array: { variableName: "replacement", ... }
	 * @return {String} Translated message.
	 * @author Andy Wermke, https://github.com/andywer/laravel-js-localization
	 */
	t: function(messageKey, replacements) {
		if (typeof phrases[messageKey] == "undefined") {
			/* like Lang::get(), if messageKey is the name of a lang file, return it as an array */
			var result = {};
			for (var prop in phrases) {
				if (prop.indexOf(messageKey + '.') > -1) {
					result[prop] = phrases[prop];
				}
			};
			if (!_.isEmpty(result)) {
				return result;
			}
			/* if there is nothing to return, return messageKey */
			return messageKey;
		}

		var message = phrases[messageKey];

		if (replacements) {
			message = applyReplacements(message, replacements);
		}

		return message;
	},

	/**
	 * Returns whether the given message is defined or not.
	 *
	 * @method has
	 * @static
	 * @param {String} messageKey   Message key.
	 * @return {Boolean} True if the given message exists.
	 * @author Andy Wermke, https://github.com/andywer/laravel-js-localization
	 */
	has : function(messageKey) {
		return typeof phrases[messageKey] != "undefined";
	},

	/**
	 * Choose one of multiple message versions, based on
	 * pluralization rules. Only English pluralization
	 * supported for now. If `count` is one then the first
	 * version of the message is retuned, otherwise the
	 * second version.
	 *
	 * @method choice
	 * @static
	 * @param {String} messageKey       Message key.
	 * @param {Integer} count           Subject count for pluralization.
	 * @param {Object} [replacements]   Associative array: { variableName: "replacement", ... }
	 * @return {String} Translated message.
	 * @author Andy Wermke, https://github.com/andywer/laravel-js-localization
	 */
	choice : function(messageKey, count, replacements) {
		if (typeof phrases[messageKey] == "undefined") {
			return messageKey;
		}

		var message;
		var messageSplitted = phrases[messageKey].split('|');

		if (count == 1) {
			message = messageSplitted[0];
		} else {
			message = messageSplitted[1];
		}

		if (replacements) {
			message = applyReplacements(message, replacements);
		}

		return message;
	},
	
    /**
     * Replace variables used in the message by appropriate values.
     *
     * @method applyReplacements
     * @static
     * @param {String} message      Input message.
     * @param {Object} replacements Associative array: { variableName: "replacement", ... }
     * @return {String} The input message with all replacements applied.
	 * @author Andy Wermke, https://github.com/andywer/laravel-js-localization
     */
    applyReplacements: function (message, replacements) {
        for (var replacementName in replacements) {
            var replacement = replacements[replacementName];

            var regex = new RegExp(':'+replacementName, 'g');
            message = message.replace(regex, replacement);
        }

        return message;
    }
	
};

ViewUtils = {

	parseComment: function(text) {
		// Replacements that should be ignored by _.escape method 
		var replacements = [];
		
		// Code bases on PHP implementation from Viscacha (viscacha.org) - Author: M. Mohr
		// See: http://en.wikipedia.org/wiki/URI_scheme
		var url_protocol = "([a-z]{3,9}:\\/\\/|www\\.)";
		var url_auth = "(?:(?:[\\w\\d\\-\\.]{1,}\\:)?[\\w\\d\\-\\._]{1,}@)?"; // Authorisation information
		var url_host = "(?:\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}|[a-z\\d\\.\\-]{2,}\\.[a-z]{2,7})(?:\\:\\d+)?"; // Host (domain, tld, ip, port)
		var url_path = "(?:\\/[\\w\\d\\/;\\-%@\\~,\\.\\+\\!&=_]*)?"; // Path
		var url_query = "(?:\\?[\\w\\d=\\&;\\.:,\\_\\-\\/%@\\+\\~\\[\\]]*)?"; // Query String
		var url_fragment = "(?:#[\\w\\d\\-\\/.]*)?"; // Fragment
		var non_url_begin = "(?:[^a-z]|^)"; // Chars that seperate the beginning of an URI from the rest of the text
		var non_url_end = "(?:[\\s\\(\\)<>\"']|$)"; // Chars that seperate the end of an URI from the rest of the text

		// URL RegExp - Four matches: 
		// - First is the separating char from beginning
		// - Second is the whole url
		// - Third is the URI scheme (protocoll or www. for convenience)
		// - Fourth is the separating char from the end
		var url_regex = "(" + non_url_begin + ")(" + url_protocol + url_auth + url_host + url_path + url_query + url_fragment + ")(" + non_url_end + ")";

		// Replace the URLs finally
		text = text.replace(new RegExp(url_regex, "ig"), function($0, $1, $2, $3, $4){
			var prefix = '';
			// Append http:// if URL begins with www.
			if ($3.toLowerCase() === 'www.') {
				prefix = 'http://';
			}
			// Make link and add it to the replacements
			var num = replacements.length;
			replacements[num] = $1 + '<a href="' + prefix + $2 + '" target="_blank">' + $2 + '</a>' + $4;
			return '{{PARSER_REPLACEMENT:' + num + '}}';
		});
		
		// Escape text (avoid HTML and XSS)
		text = _.escape(text);

		// Replace the Replacements 
		text = text.replace(/{{PARSER_REPLACEMENT:(\d+)}}/g, function($0, $1){
			return replacements[$1];
		});

		return text;
	},
	
	join: function(sep, elements) {
		var filled = [];
		_.each(elements, function(element) {
			if (!_.isEmpty(element)) {
				filled.push(element);
			}
		});
		return filled.join(sep);
	}
	
};

// Onload initialisation
$(document).ready(function() {
	AuthUser.init();
});
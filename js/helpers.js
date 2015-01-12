Debug = {
	log: function(message) {
		if (config.debug) {
			console.log(message);
		}
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
		var html = '<img src="/img/loading.gif" alt="Loading data..." title="Loading data..." />';
		$(id).html(html);
	},
	
	stop: function(id) {
		Progress.hide(id);
	}
	
};

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

/*
 * Class to handle the language phrases.
 * 
 * This code bases on an implementation from https://github.com/andywer/laravel-js-localization !
 * The code is released under the MIT license.
 * 
 * @author Andy Wermke, https://github.com/andywer/laravel-js-localization
 */
Lang = {
	
	/**
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
			if (!isEmpty(result)) {
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
    },

    /**
	 * @author Andy Wermke, https://github.com/andywer/laravel-js-localization
     */
    isEmpty: function (obj) {
        for(var prop in obj) {
            if(obj.hasOwnProperty(prop))
                return false;
        }

        return true;
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
	}
	
};

// Onload initialisation
$(document).ready(function() {
	AuthUser.init();
});

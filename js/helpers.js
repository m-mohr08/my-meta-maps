var FormErrorMessages = {

	errorClass: 'invalid',
	
	apply: function(form, json) {
		this.remove(form);
		var that = this;
		$.each(json, function(field, message) {
			var elm = $(form).find("*[name='" + field + "']").parent(".form-group");
			elm.addClass(that.errorClass);
			elm.find('.error-message').text(message);
		});
	},
	
	remove: function(form) {
		$(form).find("." + this.errorClass).removeClass(this.errorClass);
	}
	
};

var AuthUser = {
	
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

var MessageBox = {

	dismissPermanently: function(name) {
		console.log("Dismissing message: " + name);
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
			html += '<strong>' + title + '</strong>&nbsp;&nbsp;';
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

// Onload initialisation
$(document).ready(function() {
	AuthUser.init();
});

/*
 * Make table rows clickable 
 */
function makeClickable(elem) {
	$(".hrefRow", elem).click(function() {
		window.document.location = $(this).data("url");
	});
}
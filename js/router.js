var Router = Backbone.Router.extend({
	routes: {
		'': 'map',
		'language/:code': 'language',
		'about': 'about',
		'help': 'help',
		'map': 'map',
		'auth': 'loginout',
		'register': 'register',
		'profile': 'profile',
		'comments/add': 'addComment',
		'comments/add2': 'addComment2',
	},

	language: function (code) {
		// TODO
	},

	about: function () {
		new AboutView();
	},

	help: function () {
		new HelpView();
	},

	map: function () {
		new MapView();
	},

	loginout: function () {
		if (AuthUser.loggedIn) {
			userLogoutController();
		}
		else {
			new LoginView();
		}
	},

	register: function () {
		new RegisterView();
	},

	profile: function () {
		new ProfileView();
	},

	addComment: function () {
		new CommentAddViewStep1();
	},

	addComment2: function () {
		new CommentAddViewStep2();
	}

});

var router = new Router();
Backbone.history.start();

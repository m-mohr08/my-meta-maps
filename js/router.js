var Router = Backbone.Router.extend({
	routes: {
		'': 'map',
		'about': 'about',
		'help': 'help',
		'auth': 'loginout',
		'register': 'register',
		'profile': 'profile',
		'password': 'password',
		'comments/add': 'addComment',
		'comments/add2': 'addComment2',
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

	password: function () {
		new PasswordView();
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

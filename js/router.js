/**
 * @namespace
 */
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
		'geodata/:id': 'geodata',
		'geodata/:gid/comment/:cid': 'comment',
		'search/:hash': 'search',
		'oauth/failed': 'oauthFailed'
		
	},

	about: function () {
		ContentView.register(new AboutView());
	},

	help: function () {
		ContentView.register(new HelpView());
	},

	map: function () {
		ContentView.register(new MapView());
	},

	oauthFailed: function (action) {
		this.navigate('/', true);
		MessageBox.addError(Lang.t('providerFail'));
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
		new ProfileView();et
	},

	password: function () {
		new PasswordView();
	},

	addComment: function () {
		this.navigate('/comments/add'); // Set correct url if not already set.
		new CommentAddViewStep1();
	},

	geodata: function (id) {
		this.navigate('/geodata/' + id); // Set correct url if not already set.
		commentsToGeodataController(id);
	},

	comment: function (gid, cid) {
		this.navigate('/geodata/' + gid + '/comment/' + cid); // Set correct url if not already set.
		commentsToGeodataController(gid, cid);
	},

	search: function (hash) {
		this.navigate('/search/' + hash); // Set correct url if not already set.
		ContentView.register(new MapView({searchHash: hash}));
	},

});

var router = new Router();
Backbone.history.start();

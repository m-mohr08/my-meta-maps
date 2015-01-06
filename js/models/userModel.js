/*
 * Model for register as user
 */
UserRegister = Backbone.Model.extend({     
	urlRoot: '/api/internal/user/register'
});

/*
 * Model for login as user with mmm method 
 */
UserLogin = Backbone.Model.extend({     
	urlRoot: '/api/internal/user/login/mmm'
});

/*
 * Model for login as user with mmm method 
 */
UserLoginOAuth = Backbone.Model.extend({     
	urlRoot: '/api/internal/user/login/oauth'
});
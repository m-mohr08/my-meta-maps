/*
 * Model for register as user
 */
UserRegister = BaseModel.extend({     
	urlRoot: '/api/internal/user/register'
});

/*
 * Model for login as user with mmm method 
 */
UserLogin = BaseModel.extend({     
	urlRoot: '/api/internal/user/login/mmm'
});

/*
 * Model for login as user with mmm method 
 */
UserLogout = BaseModel.extend({     
	urlRoot: '/api/internal/user/logout'
});

/*
 * Model for login as user with mmm method 
 */
UserLoginOAuth = BaseModel.extend({     
	urlRoot: '/api/internal/user/login/oauth'
});

/*
 * Model for change general user data
 */
UserChangeGeneral = BaseModel.extend({     
	urlRoot: '/api/internal/user/change/general'
});

/*
 * Model for change password
 */
UserChangePassword= BaseModel.extend({     
	urlRoot: '/api/internal/user/change/password'
});
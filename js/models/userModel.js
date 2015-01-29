/**
 * Model for register as user
 * @extends BaseModel
 * @namespace
 */
UserRegister = BaseModel.extend({     
	urlRoot: '/api/internal/user/register'
});

/**
 * Model for login as user with mmm method 
 * @extends BaseModel
 * @namespace
 */
UserLogin = BaseModel.extend({     
	urlRoot: '/api/internal/user/login/mmm'
});

/**
 * Model for login as user with mmm method 
 * @extends BaseModel
 * @namespace
 */
UserLogout = BaseModel.extend({     
	urlRoot: '/api/internal/user/logout'
});

/**
 * Model for login as user with mmm method 
 * @extends BaseModel
 * @namespace
 */
UserLoginOAuth = BaseModel.extend({     
	urlRoot: '/api/internal/user/login/oauth'
});

/**
 * Model for change general user data
 * @extends BaseModel
 * @namespace
 */
UserChangeGeneral = BaseModel.extend({     
	urlRoot: '/api/internal/user/change/general'
});

/**
 * Model for change password
 * @extends BaseModel
 * @namespace
 */
UserChangePassword = BaseModel.extend({     
	urlRoot: '/api/internal/user/change/password'
});

/**
 * Model to check user data before registration
 * @extends BaseModel
 * @namespace
 */
UserCheckData = BaseModel.extend({
	urlRoot: '/api/internal/user/check'
});
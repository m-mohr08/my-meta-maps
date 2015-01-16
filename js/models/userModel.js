/**
 * Model for register as user
 * Extend BaseModel
 */
UserRegister = BaseModel.extend({     
	urlRoot: '/api/internal/user/register'
});

/**
 * Model for login as user with mmm method 
 * Extend BaseModel
 */
UserLogin = BaseModel.extend({     
	urlRoot: '/api/internal/user/login/mmm'
});

/**
 * Model for login as user with mmm method 
 * Extend BaseModel
 */
UserLogout = BaseModel.extend({     
	urlRoot: '/api/internal/user/logout'
});

/**
 * Model for login as user with mmm method 
 * Extend BaseModel
 */
UserLoginOAuth = BaseModel.extend({     
	urlRoot: '/api/internal/user/login/oauth'
});

/**
 * Model for change general user data
 * Extend BaseModel
 */
UserChangeGeneral = BaseModel.extend({     
	urlRoot: '/api/internal/user/change/general'
});

/**
 * Model for change password
 * Extend BaseModel
 */
UserChangePassword = BaseModel.extend({     
	urlRoot: '/api/internal/user/change/password'
});

/**
 * Model to check user data before registration
 * Extend BaseModel
 */
UserCheckData = BaseModel.extend({
	urlRoot: '/api/internal/user/check'
});
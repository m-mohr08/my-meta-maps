/**
 * Model for validate URL of a new comment which will be added
 * @extends BaseModel
 * @namespace
 */
CommentAddFirstStep = BaseModel.extend({
	urlRoot: '/api/internal/geodata/metadata'	
});

/**
 * Model for adding comments
 * @extends BaseModel
 * @namespace
 */
CommentAddSecondStep = BaseModel.extend({     
	urlRoot: '/api/internal/geodata/add'
});

/**
 * Model for (showing) geodata
 * @extends BaseModel
 * @namespace
 */
GeodataShow = BaseModel.extend({
	urlRoot: '/api/internal/geodata/list'
});

/**
 * Model for (showing) comments to a geodata
 * @extends BaseModel
 * @namespace
 */
CommentsToGeodata = BaseModel.extend({
	id: null,
	enableAntiFlood: false,
	urlRoot: function() {
		return '/api/internal/geodata/'+this.id+'/comments';
	}
});

/**
 * Model for saving search permalinks
 * @extends BaseModel
 * @namespace
 */
PermalinkSave = BaseModel.extend({
	urlRoot: '/api/internal/geodata/search/save'
});

/**
 * Model for loading search permalinks
 * @extends BaseModel
 * @namespace
 */
PermalinkLoad = BaseModel.extend({
	id: null,
	urlRoot: function() {
		return '/api/internal/geodata/search/load/' + this.id;
	}
});
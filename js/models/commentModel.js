/*
 * Model for validate URL of a new comment which will be added
 */
CommentAddFirstStep = BaseModel.extend({
	urlRoot: '/api/internal/geodata/metadata'	
});

/*
 * Model for adding comments
 */
CommentAddSecondStep = BaseModel.extend({     
	urlRoot: '/api/internal/geodata/add'
});

/*
 * Model for (showing) geodata
 */
GeodataShow = BaseModel.extend({
	urlRoot: '/api/internal/geodata/list'
});

/*
 * Model for (showing) comments to a geodata
 */
CommentsToGeodata = BaseModel.extend({
	id: null,
	enableAntiFlood: false,
	urlRoot: function() {
		return '/api/internal/geodata/'+this.id+'/comments';
	}
});
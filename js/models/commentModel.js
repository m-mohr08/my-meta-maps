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
 * Model for (showing) comments
 */
CommentsShow = BaseModel.extend({
	urlRoot: '/api/internal/geodata/list'
});

/*
 * Model for comments of a geodata
 */
CommentsOfGeodata = BaseModel.extend({
	urlRoot: '/api/internal/geodata/id/comments'
});
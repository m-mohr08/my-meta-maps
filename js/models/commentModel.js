/*
 * Model for validate URL of a new comment which will be added
 */
CommentAddFirstStep = Backbone.Model.extend({
	urlRoot: '/api/internal/geodata/metadata'	
});

/*
 * Model for adding comments
 */
CommentAddSecondStep = Backbone.Model.extend({     
	urlRoot: '/api/internal/geodata/add'
});

/*
 * Model for (showing) comments
 */
CommentsShow = Backbone.Model.extend({
	urlRoot: '/api/internal/geodata/list'
});

/*
 * Collection of Comments-models
 */
CommentsShowList = Backbone.Collection.extend({
	model: CommentsShow
});

/*
 * Model for comments of a geodata
 */
CommentsOfGeodata = Backbone.Model.extend({
	urlRoot: '/api/internal/geodata/id/comments'
});
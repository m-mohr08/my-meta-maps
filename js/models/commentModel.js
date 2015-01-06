/*
 * Model for adding comments
 */
CommentAdd = Backbone.Model.extend({     
	urlRoot: '/api/internal/geodata/add'
});

/*
 * Model for comments
 */
Comments = Backbone.Model.extend({
	urlRoot: '/api/internal/geodata/list'
});

/*
 * Collection of Comments-models
 */
CommentsList = Backbone.Collection.extend({
	model: Comments
});

/*
 * Model for validate URL of a new comment which will be added
 */
CommentAddURL = Backbone.Model.extend({
	urlRoot: '/api/internal/geodata/metadata'	
});

/*
 * Model for comments of a geodata
 */
CommentsOfGeodata = Backbone.Model.extend({
	urlRoot: '/api/internal/geodata/id/comments'
});
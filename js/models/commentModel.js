/*
 * Model for adding comments/geodata
 */
CommentAdd = Backbone.Model.extend({     
	urlRoot: '/api/internal/geodata/add'
});

/*
 * Model for comments/geodata with spatial reference
 */
CommentsWithSpatial = Backbone.Model.extend({
	urlRoot: '/api/internal/geodata/list'
});

/*
 * Collection of CommentsWithSpatial-models
 */
CommentsWSList = Backbone.Collection.extend({
	model: CommentsWithSpatial
});

/*
 * Model for comments/geodata without spatial reference
 */
CommentsNoSpatial = Backbone.Model.extend({
	urlRoot: '/api/internal/geodata/list/junk'
});

/*
 * Collection of CommentsNo-models
 */
CommentsNSList = Backbone.Collection.extend({
	model: CommentsNoSpatial
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
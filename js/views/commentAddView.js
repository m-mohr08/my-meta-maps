/*
* View for CommentAdd
*/
CommentAddView = Backbone.View.extend({ 

	initialize: function(){
            this.render();
        },
        
    render: function(){
    	
    	var that = this;
    	
    	$.get('/js/templates/addCommentTemplate.html', function(data){
			template = _.template(data, {});
			that.$el.html(template);
		}, 'html');
    },
    
    events: {
    	"click #addCommentBtn": "createComment"
    },

	/*
	 * This function is called when anybody creates a comment
	 */
	createComment: function(event) {
				
		// Creates details of a comment with typed in values
		var details = createDetails();
		
		if(validateURL(details.url) === false || details.text === '' 
			|| validateDatesRelation(details.startDate, details.endDate) === false) {
			// do nothing; the formValidator will do this for you ;)
		}
		
		else {
			
			// Creates a new CommentAdd-Model
			var caModel = new CommentAdd();
			
			var caURLModel = new CommentAddURL();
			
			commentAddURLController(caURLModel, caModel, details);
		}
	}
});

var commentAddView = new CommentAddView({ el: $("#addCommentContainer") });
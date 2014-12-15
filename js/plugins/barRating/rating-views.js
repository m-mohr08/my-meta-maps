$(function () {
	$('.rating-enable').click(function () {
    	$('#example-a').barrating();

        $('#example-b').barrating('show', {
           	showSelectedRating:true
        });

        $('#example-c, #example-d').barrating('show', {
           	initialRating: true,
            showValues:true,
            showSelectedRating:false
        });

        $('#example-e').barrating('show', {
            initialRating:'A',                    
            showValues:true,
            showSelectedRating:false,
            onSelect:function(value, text) {
            alert('Selected rating: ' + value);
        }
        });

        $('#example-f').barrating({ 
        	initialRating: true,
           	showSelectedRating:false});

        $('#example-g').barrating('show', {
            showSelectedRating:true,
            reverse:true
        });
                
        $('#example-h').barrating({ 
          	initialRating: true,
           	showSelectedRating:false});

        $(this).addClass('deactivated');
        $('.rating-disable').removeClass('deactivated');
  	});

        $('.rating-disable').click(function () {
       		$('select').barrating('destroy');
        	$(this).addClass('deactivated');
            $('.rating-enable').removeClass('deactivated');
        });

        $('.rating-enable').trigger('click');
});
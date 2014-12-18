$(function () {
	$('.rating-enable').click(function () {
            	
    	$('#spatialFilter').barrating('show', {
           	initialRating: true,
            showValues:true,
            showSelectedRating:false
        });
                
        $('#ratingFilter').barrating({ 
          	initialRating: true,
           	showSelectedRating:false});

        $('#ratingComment').barrating({ 
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
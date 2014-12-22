$(function () {
	$('.rating-enable').click(function () {
            	
    	$('#spatialFilter').barrating('show', {
            showValues:true,
            showSelectedRating:false
        });
                
        $('#ratingFilter').barrating({ 
           	showSelectedRating:false});

        $('#ratingComment').barrating({
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
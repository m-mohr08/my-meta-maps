$(function () {
	$('.rating-enable').click(function () {
            	
    	$('#spatialFilter').barrating('show', {
           	initialRating: "",
            showValues:true,
            showSelectedRating:false
        });
                
        $('#ratingFilter').barrating({ 
          	initialRating: "",
           	showSelectedRating:false});

        $('#ratingComment').barrating({ 
          	initialRating: "",
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
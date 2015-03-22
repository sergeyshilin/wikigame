$(document).ready(function() {
	$('.way').each(function(){

        $way = $(this);
        var height = $way.find(".way_nodes").height(); 
        $way.height(height + 3 + 'px');
    });
});
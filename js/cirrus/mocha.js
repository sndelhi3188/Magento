(function($) { 

$(document).ready(function(){
     $('#home-slideshow')
	 	.before('<div id="nav">')
		.cycle({
		fx: 'fade',
		speed:    1500, 
 		timeout:  5000,
 		pause: 1,
 		delay:  5000, 
		pager: '#nav'
	});
});
 })(jQuery)
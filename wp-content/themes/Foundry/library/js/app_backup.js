$(document).foundation();

// add header animations based on the excellent jquery waypoints plugin by Caleb Troughton
// thank you codrops (http://tympanus.net/Development/HeaderEffects/)

var $container = $( '.nav-floater' );
$( '.header-waypoint' ).each( function(i) {
	var $el = $( this ),
		animClassDown = $el.data( 'animateDown' ),
		animClassUp = $el.data( 'animateUp' );

	$el.waypoint( function( direction ) {
		if( direction === 'down' && animClassDown ) {
			$container.attr('class', 'nav-floater-show contain-to-grid show-for-medium-up transparent darkshadow');
		}
		else if( direction === 'up' && animClassUp ){
			$container.attr('class', 'nav-floater-hide contain-to-grid show-for-medium-up transparent darkshadow');
		}
	}, { offset: '-100px' } );
} );



// add function to make .subnav sticky on scroll and make it wait till thumbnail is loaded
/*setTimeout(function () {

	// fix sub nav on scroll
	var	nav = $('.subnav'),
		thumb = $('.page-thumbnail').outerHeight(),
		navTop = thumb + 40,
		isFixed = 0;
 
	function processScroll() {
		var scrollTop = $(window).scrollTop();
		if (scrollTop >= navTop && !isFixed) {
			isFixed = 1;
			nav.addClass('stuck');
		} else if (scrollTop <= navTop && isFixed) {
			isFixed = 0;
			nav.removeClass('stuck');
		}
	}
	$(window).on('scroll', processScroll);

}, 1000);
*/
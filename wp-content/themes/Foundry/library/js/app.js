$(document).foundation();

// add header animations based on the excellent jquery waypoints plugin by Caleb Troughton
// thank you codrops (http://tympanus.net/Development/HeaderEffects/)


/*var $container = $( '.nav-container' );
var $logo = $( '.logo' );
$( '.header-waypoint' ).each( function(i) {
	var $el = $( this ),
		animClassDown = $el.data( 'animateDown' ),
		animClassUp = $el.data( 'animateUp' );

	$el.waypoint( function( direction ) {
		if( direction === 'down' && animClassDown ) {
			$container.attr('class', 'nav-container animate small contain-to-grid fixed show-for-medium-up transparent darkshadow');
			$logo.attr('class', 'logo animate');
		}
		else if( direction === 'up' && animClassUp ){
			$container.attr('class', 'nav-container animate large contain-to-grid fixed show-for-medium-up transparent darkshadow');
			$logo.attr('class', 'logo animate lightshadow');
		}
	}, { offset: '0px' } );
} );
*/

// add function to make .subnav sticky, using the waypoints plugin by Caleb Troughton
// thank you Caleb (http://imakewebthings.com/waypoints/guides/getting-started/)
var	nav = $('.sidebar'),
	navTop = 140,
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

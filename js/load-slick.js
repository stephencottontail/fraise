/**
 * File load-slick.js.
 *
 * Loads Slick carousel if necessary
 */

jQuery( document ).ready( function( $ ) {
	var slider = $( '.header-slider' );
	
	slider.slick( {
		dots: false,
		slidesToShow: 1,
		arrows: false,
		autoplay: true,
		speed: 1200,
		cssEase: 'ease',
		autoplaySpeed: 6000,
		draggable: true,
		pauseOnHover: false,
		fade: true,
		infinite: true
	} );
} );
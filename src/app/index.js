import './style.scss';

// Slider - Library import example
// import { tns } from "tiny-slider"

document.addEventListener( 'DOMContentLoaded', () => {
	// Slider example
	// document.querySelectorAll( '.wp-block-gallery.is-style-gallery-slider' ).forEach( ( slides ) => {
	// 	const slider = tns( {
	// 		container: slides,
	// 		items: 1,
	// 		slideBy: 'page',
	// 		autoplay: true,
	// 		nonce: 'blurns'
	// 	} );
	// } );

	// Lazy load fade in
	document.querySelectorAll( 'img[loading="lazy"]' ).forEach( ( img ) => {
		if( img.complete === true ) {
			img.classList.add( 'has-loaded' );
		}
		img.addEventListener( "load", ( e ) => {
			e.target.classList.add( 'has-loaded' );
		} );
	} );
} );
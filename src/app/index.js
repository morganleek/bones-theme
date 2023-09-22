import './style.scss';

// Slider - Library import example
// import { tns } from "tiny-slider"

document.addEventListener( 'DOMContentLoaded', () => {
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
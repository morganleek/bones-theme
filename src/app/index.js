import './style.scss';

import { gsap } from "gsap";    
import { ScrollTrigger } from "gsap/ScrollTrigger";
gsap.registerPlugin(ScrollTrigger);

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

	// Scroll trigger for navigation on the homepage
	if( document.querySelector( 'body.home' ) ) {
		const header = document.querySelector( 'header.wp-block-template-part' );
		const banner = document.querySelector( '.wp-block-post-content > *:nth-child(1)' );
		const offset = banner.offsetHeight - 120;

		let st = ScrollTrigger.create({
			trigger: document.querySelector( '.wp-block-post-content > *:nth-child(1)' ),
			// start: `${offset}px top`,
			start: '60% top',
			end: "10000px",
			// markers: true,
			onToggle: (self) => header.classList.toggle( 'active', self.isActive )
		});
	}

	// Copyright Year
	document.querySelectorAll(".copyright").forEach( ( p ) => { 
		p.innerHTML = p.innerHTML.replace( '{YEAR}', new Date().getUTCFullYear() );
	} );
} );
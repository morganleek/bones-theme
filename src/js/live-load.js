// import { hydrateRegions } from '@wordpress/interactivity';

const createOrUpdateId = ( ids, source ) => {
	let foundIds = [];
	source.querySelectorAll( ids.join( "," ) ).forEach( node => {
		const { id } = node;
		if( id === undefined ) {
			return;
		}
		foundIds.push( id );
		console.log( node );

		if( source.getElementById( id ) ) {
			if( document.getElementById( id ) ) { // both exist, replace
				document.getElementById( id ).replaceWith( source.getElementById( id ) );
			}
			else { // destination doesn't exist, create
				if( node.tagName === 'STYLE' ) {
					document.head.appendChild( source.getElementById( id ) );
				}
				else {
					document.body.appendChild( source.getElementById( id ) );
				}
			}
		}
		else {
			if( document.getElementById( id ) ) { // no new source, remove exisiting
				document.getElementById( id ).remove();
			}
		}
	} );

	// Remove unneccessary inline styles
	// console.log( foundIds );
	// document.querySelectorAll( "style[id*='inline-css']" ).forEach( ( { id } ) => {
	// 	if( !foundIds.includes( id ) ) {
	// 		console.log( id );
	// 	}
	// } );
}

// const createOrUpdateSelector = ( selector, source ) => {
// 	if( source.querySelector( selector ) ) {
// 		if( document.querySelector( selector ) ) { // both exist, replcae
// 			document.querySelector( selector ).replaceWith( source.querySelector( selector ) );
// 		}
// 		else { // destination doesn't exist, create
// 			document.body.appendChild( source.querySelector( selector ) );
// 		}
// 	}
// 	else {
// 		if( document.querySelector( selector ) ) { // no new source, remove exisiting
// 			document.querySelector( selector ).remove();
// 		}
// 	}
// }

document.addEventListener( 'DOMContentLoaded', () => {
	const loadPage = href => {
		document.body.classList.add( 'in-load' );

		setTimeout( () => {
			fetch( href )
				.then( response => response.text() )
				.then( html => {
					const parser = new DOMParser();
					const doc = parser.parseFromString( html, 'text/html' );
	
					if( document.head && doc.head ) {
						document.head.replaceWith( doc.head );
					}
	
					// Ids
					const ids = [
						"[id='wp-script-module-data-@wordpress/interactivity']",
						"#wpadminbar",
						"script[id^='@wordpress/block-library/'][id$='/view-js-module']",
						// "style[id*='inline-css']"
					];
					// doc.querySelectorAll( "script[id^='@wordpress/block-library/'][id$='/view-js-module']" ).forEach( script => {
					// 	ids.push( script.id );
					// } );
					// doc.querySelectorAll( "style[id*='inline-css']" ).forEach( style => {
					// 	ids.push( style.id );
					// } );
					// ids.forEach( id => { createOrUpdateId( id, doc ) } );
					createOrUpdateId( ids, doc );
	
					// Query selectors
					// const selectors = [
					// 	"header nav.wp-block-navigation"
					// ];
					// selectors.forEach( selector => { createOrUpdateSelector( selector, doc ) } );
	
					// if( doc.getElementById( "wp-script-module-data-@wordpress/interactivity" ) ) {
					// 	if( document.getElementById( "wp-script-module-data-@wordpress/interactivity" ) ) {
					// 		document.getElementById( "wp-script-module-data-@wordpress/interactivity" ).replaceWith( doc.getElementById( "wp-script-module-data-@wordpress/interactivity" ) );
					// 	}
					// 	else {
					// 		document.body.appendChild( doc.getElementById( "wp-script-module-data-@wordpress/interactivity" ) );
					// 	}
					// } 
	
					// title 
					// if( document.querySelector( "title" ) && doc.querySelector( "title" ) ) {
					// 	document.querySelector( "title" ).replaceWith( doc.querySelector( "title" ) );
					// }
	
					// Replace admin 
					if( document.getElementById( "wpadminbar" ) && doc.getElementById( "wpadminbar" ) ) {
						document.getElementById( "wpadminbar" ).replaceWith( doc.getElementById( "wpadminbar" ) );
					}
	
					// Replace header
					if( document.querySelector( "header nav.wp-block-navigation" ) && doc.querySelector( "header nav.wp-block-navigation" ) ) {
						document.querySelector( "header nav.wp-block-navigation" ).replaceWith( doc.querySelector( "header nav.wp-block-navigation" ) );
					}
					
					// Replace main
					if( doc.querySelector( "main" ) ) {
						document.querySelector( "main" )?.replaceWith( doc.querySelector( "main" ) );
					}



					// Interactivity module
					if( document.getElementById( "@wordpress/interactivity-js-modulepreload" ) ) {
						//  && doc.getElementById( "@wordpress/interactivity-js-modulepreload" )
						console.log( "yet" );
						const newInteractivity = document.getElementById( "@wordpress/interactivity-js-modulepreload" );
						// newInteractivity.href += "&cp=" + Date.now();

						fetch( newInteractivity.href )
							.then( response => response.text() )
							.then( js => {
								// console.log( js.indexOf("DOMContentLoaded") );
								let patchedJs = js.replaceAll( "DOMContentLoaded", "DOMContentUpdated" );
								// patchedJs = patchedJs.replaceAll( "gr(Lr);", "gr(Lr);debugger;Lr();" );
								// patchedJs = patchedJs.replaceAll( "Ot(Gt());", "debugger;Ot(Gt());" );
								// patchedJs = patchedJs.replaceAll( "await te();", "" );
								patchedJs = patchedJs.replaceAll( "var i,s;", "debugger;var i,s;" );
								// wp-block-accordion

								const blob = new Blob( [ patchedJs ], { type: 'text/javascript' } );
								const script = document.createElement( 'script' );
								script.type = 'module';
								script.src = URL.createObjectURL( blob );
								document.body.appendChild( script );
								if( document.getElementById( "@wordpress/interactivity-js-modulepreload" ) ) {
									document.getElementById( "@wordpress/interactivity-js-modulepreload" ).replaceWith( script );
								}
								else {
									document.body.appendChild( script );
								}
						} );
					}
					else {
						console.log( "niet", document.getElementById( "@wordpress/interactivity-js-modulepreload" ), doc.getElementById( "@wordpress/interactivity-js-modulepreload" ) );
					}
					setTimeout( () => { 
						document.body.classList.remove( 'in-load' ); 
						const event = new CustomEvent( "DOMContentUpdated", { detail: { message: "DOM Content Reloaded" } } );
						document.dispatchEvent( event );
					}, 600 );
				} );
		}, 300 );

	};

	document.body.addEventListener( 'click', e => {
		if( e.target.closest( 'a' ) ) {
			const href = e.target.closest( 'a' ).href;
			// Same origin
			if( href.indexOf( window.location.origin ) === 0 && href.indexOf( "/wp-admin" ) === -1 ) {
				e.preventDefault();

				// Fetch page
				loadPage( href );
				history.pushState( null, '', href );	
			}
		}
	} )

	window.addEventListener( 'popstate', () => {
		loadPage( window.location.href );
	} );
} );


// wp-importmap
// @wordpress/interactivity-js-modulepreload
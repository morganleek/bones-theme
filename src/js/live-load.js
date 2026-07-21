// import { hydrateRegions } from '@wordpress/interactivity';

// document.addEventListener( 'DOMContentLoaded', () => {
// 	const loadPage = href => {
// 		const currentMain = document.querySelector( 'main' );
// 		currentMain.classList.add( 'in-load' );
// 		fetch( href )
// 			.then( response => response.text() )
// 			.then( html => {
// 				const parser = new DOMParser();
// 				const doc = parser.parseFromString( html, 'text/html' );
// 				const newMain = doc.querySelector( 'main' );
// 				// newMain.classList.add( 'in-load' );
// 				// Append missing inline styles
// 				const inlineStyles = doc.querySelectorAll( "style[id*='inline-css']" );
// 				inlineStyles.forEach( style => {
// 					if( document.querySelector( `#${style.id}` ) === null ) {
// 						document.head.appendChild( style );
// 					}
// 				} );

// 				if( doc.getElementById( "wp-script-module-data-@wordpress/interactivity" ) ) {
// 					if( document.getElementById( "wp-script-module-data-@wordpress/interactivity" ) ) {
// 						document.getElementById( "wp-script-module-data-@wordpress/interactivity" ).replaceWith( doc.getElementById( "wp-script-module-data-@wordpress/interactivity" ) );
// 					}
// 					else {
// 						document.body.appendChild( doc.getElementById( "wp-script-module-data-@wordpress/interactivity" ) );
// 					}
// 				} 

// 				// Replace admin 
// 				if( document.getElementById( "wpadminbar" ) && doc.getElementById( "wpadminbar" ) ) {
// 					document.getElementById( "wpadminbar" ).replaceWith( doc.getElementById( "wpadminbar" ) );
// 				}

// 				// Replace header
// 				if( document.querySelector( "header nav.wp-block-navigation" ) && doc.querySelector( "header nav.wp-block-navigation" ) ) {
// 					document.querySelector( "header nav.wp-block-navigation" ).replaceWith( doc.querySelector( "header nav.wp-block-navigation" ) );
// 				}
				
// 				// Replace main
// 				if( newMain && currentMain ) {
// 					setTimeout( () => {
// 						currentMain.replaceWith( newMain );
// 						// Reload scripts
// 						// hydrateRegions();
// 						// window.location.reload();
// 						// console.log( 1 );

// 						// Interactivity module
// 						if( document.getElementById( "@wordpress/interactivity-js-modulepreload" ) && doc.getElementById( "@wordpress/interactivity-js-modulepreload" ) ) {
// 							const newInteractivity = doc.getElementById( "@wordpress/interactivity-js-modulepreload" );
// 							newInteractivity.href += "&cp=" + Date.now();

// 							fetch( newInteractivity.href )
// 								.then( response => response.text() )
// 								.then( js => {
// 									// console.log( js.indexOf("DOMContentLoaded") );
// 									let patchedJs = js.replaceAll( "DOMContentLoaded", "DOMContentUpdated" );
// 									// patchedJs = patchedJs.replaceAll( "gr(Lr);", "gr(Lr);debugger;Lr();" );
// 									// patchedJs = patchedJs.replaceAll( "Ot(Gt());", "debugger;Ot(Gt());" );
// 									// patchedJs = patchedJs.replaceAll( "await te();", "" );
// 									patchedJs = patchedJs.replaceAll( "var i,s;", "debugger;var i,s;" );
// 									// wp-block-accordion

// 									const blob = new Blob( [ patchedJs ], { type: 'text/javascript' } );
// 									const script = document.createElement( 'script' );
// 									script.type = 'module';
// 									script.src = URL.createObjectURL( blob );
// 									document.body.appendChild( script );
// 								} );

// 							// document.getElementById( "@wordpress/interactivity-js-modulepreload" ).replaceWith( newInteractivity );
// 						}

// 						const event = new CustomEvent( "DOMContentUpdated", { detail: { message: "DOM Content Reloaded" } } );
// 						document.dispatchEvent( event );

// 						// setTimeout( () => {
// 						// 	document.querySelector( 'main' ).classList.remove( "in-load" );
// 						// }, 300 );
// 					}, 300 );
// 				}
// 			} );
// 	};

// 	document.body.addEventListener( 'click', e => {
// 		if( e.target.closest( 'a' ) ) {
// 			const href = e.target.closest( 'a' ).href;
// 			// Same origin
// 			if( href.indexOf( window.location.origin ) === 0 && href.indexOf( "/wp-admin" ) === -1 ) {
// 				e.preventDefault();

// 				// Fetch page
// 				loadPage( href );
// 				history.pushState( null, '', href );	
// 			}
// 		}
// 	} )

// 	window.addEventListener( 'popstate', () => {
// 		loadPage( window.location.href );
// 	} );
// } );


// // wp-importmap
// // @wordpress/interactivity-js-modulepreload
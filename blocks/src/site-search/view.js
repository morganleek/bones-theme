import domReady from "@wordpress/dom-ready";
import { createRoot } from "@wordpress/element";
import App from './site-search';

domReady( () => {	
	const container = document.querySelector( '.wp-block-bones-blocks-site-search' );
	const root = createRoot( container );
	root.render(<App />);
} );
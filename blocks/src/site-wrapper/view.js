import { store, withSyncEvent } from '@wordpress/interactivity';

store( 'bones/siteWrapper', {
	actions: {
		navigate: withSyncEvent( function* ( event ) {
			const link = event.target.closest( 'a[href]' );
			if (
				! link ||
				event.defaultPrevented ||
				event.button !== 0 ||
				event.metaKey ||
				event.ctrlKey ||
				event.shiftKey ||
				event.altKey ||
				link.target === '_blank' ||
				link.hasAttribute( 'download' ) ||
				link.origin !== window.location.origin ||
				( link.pathname === window.location.pathname && link.hash )
			) {
				return;
			}
			event.preventDefault();
			const { actions } = yield import( '@wordpress/interactivity-router' );
			yield actions.navigate( link.href );
		} ),
	},
} );

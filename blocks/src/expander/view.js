import { store, getContext, withSyncEvent } from '@wordpress/interactivity';

store( 'bones/expander', {
	actions: {
		toggle( event ) {
			// Let links inside the header behave normally.
			if ( event.target.closest( 'a[href]' ) ) {
				return;
			}
			const context = getContext();
			context.isOpen = ! context.isOpen;
		},
		onKeydown: withSyncEvent( ( event ) => {
			if ( event.key !== 'Enter' && event.key !== ' ' ) {
				return;
			}
			if ( event.target !== event.currentTarget ) {
				return;
			}
			event.preventDefault();
			const context = getContext();
			context.isOpen = ! context.isOpen;
		} ),
	},
} );

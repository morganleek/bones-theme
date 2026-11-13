import { store, getContext, getElement } from '@wordpress/interactivity';

const OPEN_CLASS = 'has-overlay-button-open';

function getDialog( ref ) {
	const id = ref?.getAttribute( 'aria-controls' );
	return id ? document.getElementById( id ) : null;
}

store( 'bones/overlay-button', {
	actions: {
		open() {
			const { ref } = getElement();
			const dialog = getDialog( ref );
			if ( ! dialog || dialog.open ) {
				return;
			}
			dialog.showModal();
			getContext().isOpen = true;
			document.documentElement.classList.add( OPEN_CLASS );
		},
		close() {
			const { ref } = getElement();
			ref?.closest( 'dialog' )?.close();
		},
		// Fired by the native dialog for close(), Esc, etc.
		onClose() {
			getContext().isOpen = false;
			if ( ! document.querySelector( 'dialog.wp-block-bones-blocks-overlay-button__dialog[open]' ) ) {
				document.documentElement.classList.remove( OPEN_CLASS );
			}
			// Return focus to the trigger.
			const { ref } = getElement();
			document
				.querySelector( `[aria-controls="${ ref.id }"]` )
				?.focus();
		},
		// Clicks on the dialog element itself (not its content) = backdrop.
		onBackdropClick( event ) {
			if ( event.target === event.currentTarget ) {
				event.currentTarget.close();
			}
		},
	},
} );

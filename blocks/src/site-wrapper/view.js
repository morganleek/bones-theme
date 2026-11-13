import { store, withSyncEvent } from '@wordpress/interactivity';

/**
 * Fluent Forms relies on classic scripts + per-form inline config
 * (`window.fluent_form_<instance>`) printed in the footer, outside the router
 * region. The router doesn't execute those, so after a client-side navigation
 * we re-initialise any forms Fluent already knows about, and fall back to a
 * full page load when it doesn't (scripts/config never loaded).
 *
 * @return {boolean} False if a full page load is required.
 */
function initFluentForms() {
	const forms = document.querySelectorAll(
		'form.frm-fluent-form[data-form_instance]'
	);
	if ( ! forms.length ) {
		return true;
	}

	const $ = window.jQuery;
	if ( ! $ || typeof window.fluentFormApp !== 'function' ) {
		return false;
	}

	for ( const form of forms ) {
		const instance = form.dataset.form_instance.replace(
			/[^a-zA-Z0-9_-]/g,
			''
		);
		if ( ! window[ `fluent_form_${ instance }` ] ) {
			return false;
		}
	}

	forms.forEach( ( form ) => $( document ).trigger( 'ff_reinit', [ form ] ) );
	return true;
}

const { state } = store( 'bones/siteWrapper', {
	state: {
		isLoading: false,
	},
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
			state.isLoading = true;
			try {
				const { actions } = yield import( '@wordpress/interactivity-router' );
				yield actions.navigate( link.href );
				if ( ! initFluentForms() ) {
					window.location.assign( link.href );
				}
			} finally {
				state.isLoading = false;
			}
		} ),
	},
} );

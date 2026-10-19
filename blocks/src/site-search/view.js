import {
	store,
	getContext,
	getElement,
	withScope,
	withSyncEvent,
} from '@wordpress/interactivity';

const DEBOUNCE_MS = 300;

// Pending debounce timers, keyed by the search input element.
const timers = new WeakMap();

const { state, actions } = store( 'bones/siteSearch', {
	state: {
		get resultItems() {
			return getContext().results?.results ?? [];
		},
		get allResultsUrl() {
			const url = new URL( state.homeUrl );
			url.searchParams.set( 's', getContext().query );
			return url.toString();
		},
	},
	actions: {
		toggle() {
			const context = getContext();
			context.isOpen = ! context.isOpen;
		},
		close() {
			getContext().isOpen = false;
		},
		onInput( event ) {
			const context = getContext();
			const { ref } = getElement();
			context.searchTerm = event.target.value;
			clearTimeout( timers.get( ref ) );
			timers.set( ref, setTimeout( withScope( actions.search ), DEBOUNCE_MS ) );
		},
		// Results update as you type, so Enter does nothing.
		onSubmit: withSyncEvent( ( event ) => {
			event.preventDefault();
		} ),
		*search() {
			const context = getContext();
			const term = context.searchTerm.trim();

			if ( ! term ) {
				context.results = null;
				context.isLoading = false;
				return;
			}

			context.isLoading = true;

			const url = new URL( state.restUrl );
			url.searchParams.set( 'search', term );

			try {
				const response = yield fetch( url );
				if ( ! response.ok ) {
					throw new Error( response.statusText );
				}
				const data = yield response.json();

				// Ignore responses for a term that has since changed.
				if ( term !== context.searchTerm.trim() ) {
					return;
				}

				context.query = term;
				context.results = data;
			} catch ( error ) {
				// eslint-disable-next-line no-console
				console.error( 'Site search failed:', error );
			} finally {
				if ( term === context.searchTerm.trim() ) {
					context.isLoading = false;
				}
			}
		},
	},
	callbacks: {
		closeOnOutsideClick( event ) {
			const context = getContext();
			const { ref } = getElement();
			if ( context.isOpen && ! ref.contains( event.target ) ) {
				context.isOpen = false;
			}
		},
		closeOnEscape( event ) {
			if ( event.key === 'Escape' ) {
				getContext().isOpen = false;
			}
		},
		focusWhenOpen() {
			const { ref } = getElement();
			if ( getContext().isOpen ) {
				ref.focus();
			}
		},
	},
} );

import 'vite/modulepreload-polyfill';
import './style.scss';

// Slider - Library import example
// import { tns } from "tiny-slider"

document.addEventListener('DOMContentLoaded', () => {

	// Copyright Year
	document.querySelectorAll(".copyright").forEach((p) => {
		p.innerHTML = p.innerHTML.replace('{YEAR}', new Date().getUTCFullYear());
	});
});

//
// Lazy Loading including items loaded via `fetch`
// 

// MutationObserver — catches <img> tags added to the DOM (including via fetch/AJAX)
const observer = new MutationObserver((mutations) => {
	mutations.forEach((mutation) => {
		mutation.addedNodes.forEach((node) => {
			if (node.nodeType !== 1) return; // Element nodes only

			// Direct <img> tags
			if (node.tagName === 'IMG') {
				attachLoadListener(node);
			}

			// <img> tags nested inside added elements
			node.querySelectorAll?.('img').forEach(attachLoadListener);
		});
	});
});

observer.observe(document.body, {
	childList: true,
	subtree: true
});

// Intercept fetch() globally — catches raw fetch calls returning image blobs
const originalFetch = window.fetch;
window.fetch = async function (...args) {
	const response = await originalFetch.apply(this, args);
	const contentType = response.headers.get('content-type') || '';

	if (contentType.startsWith('image/')) {
		// console.log('[fetch] Image loaded via fetch API:', args[0]);
		// Clone so the original response body is not consumed
		const clone = response.clone();
		clone.blob().then((blob) => {
			const url = URL.createObjectURL(blob);
			onImageLoad({ src: args[0], objectUrl: url, via: 'fetch' });
		});
	}

	return response;
};

// Catch any <img> tags already in the DOM at init time
document.querySelectorAll('img').forEach(attachLoadListener);

// --- Helpers ---

function attachLoadListener(img) {
	if (img._loadListenerAttached) return; // prevent duplicates
	img._loadListenerAttached = true;

	if (img.complete) {
		// Already loaded (cached)
		// console.log( "complete" );
		onImageLoad({ src: img.src, via: 'dom-cached', el: img });
	} else {
		img.addEventListener('load', () => {
			onImageLoad({ src: img.src, via: 'dom', el: img });
		});
		img.addEventListener('error', () => {
			console.warn('[img] Failed to load:', img.src);
		});
	}
}

function onImageLoad({ src, via, el = null, objectUrl = null }) {
	el.classList.add('has-loaded');
	el.removeAttribute( "loading" );
}
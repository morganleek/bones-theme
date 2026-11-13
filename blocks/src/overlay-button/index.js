import { registerBlockType } from '@wordpress/blocks';
import { addFilter } from '@wordpress/hooks';
import './style.scss';

import Edit from './edit';
import save from './save';
import metadata from './block.json';

registerBlockType( metadata.name, {
	edit: Edit,
	save,
} );

/**
 * Allow the Overlay Button inside core/buttons, alongside regular buttons.
 */
addFilter(
	'blocks.registerBlockType',
	'bones-blocks/overlay-button/allow-in-buttons',
	( settings, name ) => {
		if ( name !== 'core/buttons' ) {
			return settings;
		}
		const allowed = settings.allowedBlocks ?? [ 'core/button' ];
		if ( allowed.includes( metadata.name ) ) {
			return settings;
		}
		return { ...settings, allowedBlocks: [ ...allowed, metadata.name ] };
	}
);

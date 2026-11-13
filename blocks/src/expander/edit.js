import { __ } from '@wordpress/i18n';
import {
	InspectorControls,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import './editor.scss';

const TEMPLATE = [
	[ 'bones-blocks/expander-header' ],
	[ 'bones-blocks/expander-body' ],
];

export default function Edit( { attributes, setAttributes } ) {
	const { initiallyOpen } = attributes;
	const blockProps = useBlockProps();
	const innerBlocksProps = useInnerBlocksProps( blockProps, {
		allowedBlocks: [
			'bones-blocks/expander-header',
			'bones-blocks/expander-body',
		],
		template: TEMPLATE,
		templateLock: 'all',
	} );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'bones-blocks' ) }>
					<ToggleControl
						__nextHasNoMarginBottom
						label={ __( 'Open by default', 'bones-blocks' ) }
						checked={ initiallyOpen }
						onChange={ ( value ) =>
							setAttributes( { initiallyOpen: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...innerBlocksProps } />
		</>
	);
}

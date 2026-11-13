import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import './editor.scss';

const TEMPLATE = [ [ 'core/heading', { level: 3, placeholder: 'Expander title' } ] ];

export default function Edit() {
	const blockProps = useBlockProps();
	const innerBlocksProps = useInnerBlocksProps( blockProps, {
		template: TEMPLATE,
		templateLock: false,
	} );

	return <div { ...innerBlocksProps } />;
}

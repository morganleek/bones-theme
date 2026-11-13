import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import './editor.scss';

const TEMPLATE = [ [ 'core/paragraph', { placeholder: 'Expander content…' } ] ];

export default function Edit() {
	const blockProps = useBlockProps();
	const innerBlocksProps = useInnerBlocksProps( blockProps, {
		template: TEMPLATE,
		templateLock: false,
	} );

	return <div { ...innerBlocksProps } />;
}

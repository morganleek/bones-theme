import clsx from 'classnames';
import { RichText, useBlockProps } from '@wordpress/block-editor';
import { getButtonProps } from './styles';

export default function save( { attributes } ) {
	const { text, title, style } = attributes;
	const buttonProps = getButtonProps( attributes );

	return (
		<div
			{ ...useBlockProps.save( {
				className: clsx( 'wp-block-button', {
					[ `has-custom-font-size` ]: !! style?.typography?.fontSize,
				} ),
			} ) }
		>
			<RichText.Content
				tagName="button"
				type="button"
				className={ buttonProps.className }
				style={ buttonProps.style }
				title={ title }
				value={ text }
			/>
		</div>
	);
}

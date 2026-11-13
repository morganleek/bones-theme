import clsx from 'classnames';
import {
	__experimentalGetBorderClassesAndStyles as getBorderClassesAndStyles,
	__experimentalGetColorClassesAndStyles as getColorClassesAndStyles,
	__experimentalGetSpacingClassesAndStyles as getSpacingClassesAndStyles,
	__experimentalGetShadowClassesAndStyles as getShadowClassesAndStyles,
	getTypographyClassesAndStyles,
} from '@wordpress/block-editor';

/**
 * Classes and inline styles for the inner button element, mirroring core/button
 * (block supports are skip-serialized off the wrapper and applied here instead).
 *
 * @param {Object} attributes Block attributes.
 * @param {Object} fluidTypographySettings Optional fluid typography settings (editor only).
 * @return {{className: string, style: Object}} Props for the inner button.
 */
export function getButtonProps( attributes, fluidTypographySettings ) {
	const borderProps = getBorderClassesAndStyles( attributes );
	const colorProps = getColorClassesAndStyles( attributes );
	const spacingProps = getSpacingClassesAndStyles( attributes );
	const shadowProps = getShadowClassesAndStyles( attributes );
	const typographyProps = getTypographyClassesAndStyles(
		attributes,
		fluidTypographySettings
	);

	return {
		className: clsx(
			'wp-block-button__link',
			colorProps.className,
			borderProps.className,
			typographyProps.className,
			{
				[ `has-text-align-${ attributes.style?.typography?.textAlign }` ]:
					attributes.style?.typography?.textAlign,
				'no-border-radius': attributes.style?.border?.radius === 0,
			},
			// Lets theme.json `elements.button` styles apply.
			'wp-element-button'
		),
		style: {
			...borderProps.style,
			...colorProps.style,
			...spacingProps.style,
			...shadowProps.style,
			...typographyProps.style,
			writingMode: undefined,
		},
	};
}

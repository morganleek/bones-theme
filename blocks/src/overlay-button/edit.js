import clsx from 'classnames';
import { __ } from '@wordpress/i18n';
import {
	InspectorControls,
	RichText,
	useBlockProps,
	useSettings,
} from '@wordpress/block-editor';
import {
	ExternalLink,
	Notice,
	PanelBody,
	SelectControl,
	Spinner,
	TextControl,
} from '@wordpress/components';
import { useEntityRecords } from '@wordpress/core-data';
import { getButtonProps } from './styles';
import './editor.scss';

// Same template part area core/navigation uses for its "Overlay" setting.
const OVERLAY_AREA = 'navigation-overlay';

export default function Edit( { attributes, setAttributes } ) {
	const { text, title, overlay, placeholder, style } = attributes;

	const [ fluidTypographySettings, layout ] = useSettings(
		'typography.fluid',
		'layout'
	);
	const buttonProps = getButtonProps( attributes, {
		typography: { fluid: fluidTypographySettings },
		layout: { wideSize: layout?.wideSize },
	} );

	const blockProps = useBlockProps( {
		className: clsx( 'wp-block-button', {
			'has-custom-font-size': !! style?.typography?.fontSize,
		} ),
	} );

	const { records: templateParts, hasResolved } = useEntityRecords(
		'postType',
		'wp_template_part',
		{ per_page: -1 }
	);
	const overlays = ( templateParts ?? [] ).filter(
		( part ) => part.area === OVERLAY_AREA
	);
	const selected = overlays.find( ( part ) => part.slug === overlay );

	const options = [
		{ label: __( 'Select an overlay…', 'bones-blocks' ), value: '' },
		...overlays.map( ( part ) => ( {
			label: part.title?.rendered || part.slug,
			value: part.slug,
		} ) ),
	];

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Overlay', 'bones-blocks' ) }>
					{ ! hasResolved && <Spinner /> }
					{ hasResolved && overlays.length === 0 && (
						<Notice status="warning" isDismissible={ false }>
							{ __(
								'No overlay template parts found. Create one in the Site Editor under Patterns → Navigation Overlay.',
								'bones-blocks'
							) }
						</Notice>
					) }
					{ hasResolved && overlays.length > 0 && (
						<SelectControl
							__next40pxDefaultSize
							__nextHasNoMarginBottom
							label={ __( 'Overlay template', 'bones-blocks' ) }
							help={ __(
								'Template part (Navigation Overlay area) shown when the button is clicked.',
								'bones-blocks'
							) }
							value={ overlay ?? '' }
							options={ options }
							onChange={ ( value ) =>
								setAttributes( { overlay: value || undefined } )
							}
						/>
					) }
					{ hasResolved && overlay && ! selected && (
						<Notice status="error" isDismissible={ false }>
							{ __(
								'The selected overlay no longer exists.',
								'bones-blocks'
							) }
						</Notice>
					) }
					{ selected && (
						<p>
							<ExternalLink
								href={ `site-editor.php?p=${ encodeURIComponent(
									`/wp_template_part/${ selected.id }`
								) }&canvas=edit` }
							>
								{ __( 'Edit overlay', 'bones-blocks' ) }
							</ExternalLink>
						</p>
					) }
				</PanelBody>
			</InspectorControls>
			<InspectorControls group="advanced">
				<TextControl
					__next40pxDefaultSize
					__nextHasNoMarginBottom
					label={ __( 'Title attribute', 'bones-blocks' ) }
					value={ title || '' }
					onChange={ ( value ) => setAttributes( { title: value } ) }
				/>
			</InspectorControls>
			<div { ...blockProps }>
				<RichText
					aria-label={ __( 'Button text', 'bones-blocks' ) }
					placeholder={ placeholder || __( 'Add text…', 'bones-blocks' ) }
					value={ text }
					onChange={ ( value ) => setAttributes( { text: value } ) }
					withoutInteractiveFormatting
					className={ buttonProps.className }
					style={ buttonProps.style }
					identifier="text"
				/>
			</div>
		</>
	);
}

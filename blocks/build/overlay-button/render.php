<?php
/**
 * Server-side render for the Overlay Button block.
 *
 * The button markup comes from save.js ($content). Here we wire it up with
 * Interactivity API directives and append the selected overlay template part
 * inside a native <dialog>.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Saved button markup.
 * @var WP_Block $block      Block instance.
 */

$overlay_slug = isset( $attributes['overlay'] ) ? sanitize_key( $attributes['overlay'] ) : '';

if ( ! $overlay_slug ) {
	// No overlay chosen: render the plain button.
	echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}

// core/template-part handles DB vs theme-file lookup, block hooks, shortcodes
// and recursion protection for us.
$overlay_html = render_block(
	array(
		'blockName'    => 'core/template-part',
		'attrs'        => array(
			'slug'    => $overlay_slug,
			'theme'   => get_stylesheet(),
			'tagName' => 'div',
		),
		'innerBlocks'  => array(),
		'innerHTML'    => '',
		'innerContent' => array(),
	)
);

if ( '' === trim( $overlay_html ) ) {
	// Template part missing or empty.
	echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}

$dialog_id     = wp_unique_id( 'overlay-button-dialog-' );
$overlay_part  = get_block_template( get_stylesheet() . '//' . $overlay_slug, 'wp_template_part' );
$overlay_label = ( $overlay_part && $overlay_part->title ) ? $overlay_part->title : __( 'Overlay', 'bones-blocks' );

// Any Navigation Overlay Close blocks inside the overlay close this dialog.
// The namespace is explicit so it still works inside nested interactive blocks.
$overlay_tags = new WP_HTML_Tag_Processor( $overlay_html );
while ( $overlay_tags->next_tag(
	array(
		'tag_name'   => 'BUTTON',
		'class_name' => 'wp-block-navigation-overlay-close',
	)
) ) {
	$overlay_tags->set_attribute( 'data-wp-on--click', 'bones/overlay-button::actions.close' );
}
$overlay_html = $overlay_tags->get_updated_html();

// Images are hidden until the overlay opens; don't let them compete for LCP.
$overlay_tags = new WP_HTML_Tag_Processor( $overlay_html );
while ( $overlay_tags->next_tag( 'IMG' ) ) {
	$overlay_tags->set_attribute( 'fetchpriority', 'low' );
	$overlay_tags->set_attribute( 'loading', 'lazy' );
}
$overlay_html = $overlay_tags->get_updated_html();

// Add directives to the saved wrapper + button.
$tags = new WP_HTML_Tag_Processor( $content );
if ( $tags->next_tag() ) {
	$tags->set_attribute( 'data-wp-interactive', 'bones/overlay-button' );
	$tags->set_attribute( 'data-wp-context', wp_json_encode( array( 'isOpen' => false ) ) );
}
if ( $tags->next_tag( 'BUTTON' ) ) {
	$tags->set_attribute( 'aria-haspopup', 'dialog' );
	$tags->set_attribute( 'aria-controls', $dialog_id );
	$tags->set_attribute( 'aria-expanded', 'false' );
	$tags->set_attribute( 'data-wp-bind--aria-expanded', 'context.isOpen' );
	$tags->set_attribute( 'data-wp-on--click', 'actions.open' );
}
$button_html = $tags->get_updated_html();

$dialog_html = sprintf(
	'<dialog id="%1$s" class="wp-block-bones-blocks-overlay-button__dialog" aria-label="%2$s" data-wp-on--close="actions.onClose" data-wp-on--click="actions.onBackdropClick">%3$s</dialog>',
	esc_attr( $dialog_id ),
	esc_attr( $overlay_label ),
	$overlay_html
);

// Place the dialog inside the wrapper so the context/namespace cover it.
$close_pos = strrpos( $button_html, '</div>' );
if ( false !== $close_pos ) {
	$button_html = substr_replace( $button_html, $dialog_html . '</div>', $close_pos, strlen( '</div>' ) );
} else {
	$button_html .= $dialog_html;
}

echo $button_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

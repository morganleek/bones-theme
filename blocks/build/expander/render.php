<?php
/**
 * Server-side render for the Expander block.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Rendered inner blocks (header + body).
 * @var WP_Block $block      Block instance.
 */

$context = array(
	'isOpen' => ! empty( $attributes['initiallyOpen'] ),
	'bodyId' => wp_unique_id( 'expander-body-' ),
);
?>
<div
	<?php echo get_block_wrapper_attributes( array( 'data-wp-interactive' => 'bones/expander' ) ); ?>
	<?php echo wp_interactivity_data_wp_context( $context ); ?>
	data-wp-class--is-open="context.isOpen"
>
	<?php echo $content; ?>
</div>

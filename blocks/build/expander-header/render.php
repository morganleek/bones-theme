<?php
/**
 * Server-side render for the Expander Header block.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Rendered inner blocks.
 * @var WP_Block $block      Block instance.
 */
?>
<div
	<?php echo get_block_wrapper_attributes( array(
		'role'     => 'button',
		'tabindex' => '0',
	) ); ?>
	data-wp-bind--aria-expanded="context.isOpen"
	data-wp-bind--aria-controls="context.bodyId"
	data-wp-on--click="actions.toggle"
	data-wp-on--keydown="actions.onKeydown"
>
	<?php echo $content; ?>
</div>

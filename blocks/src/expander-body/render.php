<?php
/**
 * Server-side render for the Expander Body block.
 *
 * The inner wrapper lets the outer grid animate between 0fr and 1fr rows.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Rendered inner blocks.
 * @var WP_Block $block      Block instance.
 */
?>
<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-bind--id="context.bodyId"
	data-wp-bind--inert="!context.isOpen"
>
	<div class="wp-block-bones-blocks-expander-body__inner">
		<?php echo $content; ?>
	</div>
</div>

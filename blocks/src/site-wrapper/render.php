<?php
/**
 * Server-side render for the Site Wrapper block.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Rendered inner blocks.
 * @var WP_Block $block      Block instance.
 */
?>
<div <?php echo get_block_wrapper_attributes( array(
	'data-wp-interactive'   => 'bones/siteWrapper',
	'data-wp-router-region' => 'bones/siteWrapper',
	'data-wp-on--click'     => 'actions.navigate',
) ); ?>>
	<?php echo $content; ?>
</div>

<?php
/**
 * Server-side render for the Site Wrapper block.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Rendered inner blocks.
 * @var WP_Block $block      Block instance.
 */

// Only enable AJAX navigation for logged-out visitors on non-local sites.
$is_localhost = str_contains( (string) wp_parse_url( home_url(), PHP_URL_HOST ), 'localhost' );

$wrapper_attributes = ( is_user_logged_in() || $is_localhost ) ? array() : array(
	'data-wp-interactive'       => 'bones/siteWrapper',
	'data-wp-router-region'     => 'bones/siteWrapper',
	'data-wp-on--click'         => 'actions.navigate',
	'data-wp-class--is-loading' => 'state.isLoading',
);
?>
<div <?php echo get_block_wrapper_attributes( $wrapper_attributes ); ?>>
	<?php echo $content; ?>
</div>

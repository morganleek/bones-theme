<?php
/**
 * Server-side render for the Site Search block.
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Saved block content (unused).
 * @var WP_Block $block      Block instance.
 */

wp_interactivity_state( 'bones/siteSearch', array(
	'restUrl' => rest_url( 'bones/v1/search' ),
	'homeUrl' => home_url( '/' ),
) );

$context = array(
	'isOpen'     => false,
	'isLoading'  => false,
	'searchTerm' => '',
	'query'      => '',
	'results'    => null,
);
?>
<div
	<?php echo get_block_wrapper_attributes( array( 'data-wp-interactive' => 'bones/siteSearch' ) ); ?>
	<?php echo wp_interactivity_data_wp_context( $context ); ?>
	data-wp-on-document--mousedown="callbacks.closeOnOutsideClick"
	data-wp-on-document--keydown="callbacks.closeOnEscape"
>
	<button
		class="toggle-search"
		aria-label="<?php esc_attr_e( 'Open Search', 'bones-blocks' ); ?>"
		data-wp-on--click="actions.toggle"
		data-wp-bind--aria-expanded="context.isOpen"
	>
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M480 272C480 317.9 465.1 360.3 440 394.7L566.6 521.4C579.1 533.9 579.1 554.2 566.6 566.7C554.1 579.2 533.8 579.2 521.3 566.7L394.7 440C360.3 465.1 317.9 480 272 480C157.1 480 64 386.9 64 272C64 157.1 157.1 64 272 64C386.9 64 480 157.1 480 272zM272 416C351.5 416 416 351.5 416 272C416 192.5 351.5 128 272 128C192.5 128 128 192.5 128 272C128 351.5 192.5 416 272 416z"/></svg>
	</button>
	<div
		class="search-results"
		data-wp-class--is-visible="context.isOpen"
		data-wp-class--in-search="context.isLoading"
	>
		<div class="top">
			<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search" data-wp-on--submit="actions.onSubmit">
				<input
					type="search"
					name="s"
					placeholder="<?php esc_attr_e( 'Search', 'bones-blocks' ); ?>"
					autocomplete="off"
					data-wp-on--input="actions.onInput"
					data-wp-watch="callbacks.focusWhenOpen"
				/>
				<button aria-label="<?php esc_attr_e( 'Search', 'bones-blocks' ); ?>">
					<svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M16.031 14.617L20.314 18.899L18.899 20.314L14.617 16.031C13.0237 17.3082 11.042 18.0029 9 18C4.032 18 0 13.968 0 9C0 4.032 4.032 0 9 0C13.968 0 18 4.032 18 9C18.0029 11.042 17.3082 13.0237 16.031 14.617ZM14.025 13.875C15.2938 12.5697 16.0025 10.8204 16 9C16 5.133 12.867 2 9 2C5.133 2 2 5.133 2 9C2 12.867 5.133 16 9 16C10.8204 16.0025 12.5697 15.2938 13.875 14.025L14.025 13.875Z" fill="white"/>
					</svg>
				</button>
			</form>
		</div>
		<div class="bottom" data-wp-bind--hidden="!context.results">
			<p>
				<?php esc_html_e( 'Search results for', 'bones-blocks' ); ?> <span>'<span data-wp-text="context.query"></span>'</span><br />
				<?php esc_html_e( 'Showing', 'bones-blocks' ); ?> <span data-wp-text="context.results.postCount"></span>
				<?php esc_html_e( 'of', 'bones-blocks' ); ?> <span data-wp-text="context.results.totalResults"></span>
				<?php esc_html_e( 'results', 'bones-blocks' ); ?>
			</p>
			<ul class="results">
				<template data-wp-each--result="state.resultItems" data-wp-each-key="context.result.id">
					<li>
						<div class="thumbnail">
							<img
								loading="lazy"
								data-wp-bind--src="context.result.imageUrl"
								data-wp-bind--alt="context.result.imageAlt"
								data-wp-bind--hidden="!context.result.imageUrl"
							/>
						</div>
						<div class="content">
							<p class="has-overline-font-size" data-wp-text="context.result.postType"></p>
							<h6 data-wp-text="context.result.label"></h6>
						</div>
						<a
							data-wp-bind--href="context.result.url"
							data-wp-bind--aria-label="context.result.label"
							data-wp-on--click="actions.close"
						></a>
					</li>
				</template>
			</ul>
			<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex">
				<div class="wp-block-button has-icon__arrow-right">
					<a
						class="wp-block-button__link wp-element-button"
						data-wp-bind--href="state.allResultsUrl"
						data-wp-on--click="actions.close"
					>
						<?php esc_html_e( 'Show all results', 'bones-blocks' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

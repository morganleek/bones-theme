<?php
// Other functions
// require get_template_directory() . '/inc/block-patterns.php';
// WEI Images tools
// require get_template_directory() . '/inc/images.php';
// Extra tools

require get_template_directory() . '/inc/tools.php';

// Do stuff through this plugin
class BoneThemeInit
{
	public $enqueue;

	public function __construct()
	{
		$theme_version = wp_get_theme()->get('Version');
		$version_string = is_string($theme_version) ? $theme_version : '1.0.0';

		// Enqueue a few of our entry points
		add_action('wp_enqueue_scripts', [$this, 'bones_theme_plugin_enqueue']);
		add_action('after_setup_theme', [$this, 'bones_theme_support']);
		// add_action( 'admin_init', [$this, 'bones_theme_editor_styles' ] );
		// add_action( 'wp_head', [ $this, 'bones_theme_preload_webfonts' ] );
		add_action('wp_head', [$this, 'bones_theme_load_favicons']);
		add_action('init', [$this, 'bones_name_register_block_styles'], 100);
		add_action('enqueue_block_editor_assets', [$this, 'bones_theme_enqueue_block_variations']);

		// Gallery Sliders
		// add_action( 'wp_print_styles', [ $this, 'update_styles' ] );
	}

	public function bones_theme_plugin_enqueue() {
		
    $manifestPath = get_theme_file_path('dist/app/.vite/manifest.json');

		// Check if the manifest file exists and is readable before using it
		if( file_exists( $manifestPath ) ) {
			$manifest = json_decode( file_get_contents( $manifestPath ), true );
			
			// Check if the file is in the manifest before enqueuing
			if( isset( $manifest['src/app/index.js'] ) ) {
				// index.js
				wp_enqueue_script( 
					'bones-theme', 
					get_theme_file_uri( 'dist/app/' . $manifest['src/app/index.js']['file'] )
				);
				// style.css
				wp_enqueue_style(
					'bones-theme', 
					get_theme_file_uri( 'dist/app/' . $manifest['src/app/index.js']['css'][0] )
				);
			}
		}

		// Inline styles for fonts
		// wp_add_inline_style( 'bones-theme-style', $this->bones_theme_get_font_face_styles() );
	}

	public function bones_theme_support()
	{
		// Add support for block styles.
		// add_theme_support( 'wp-block-styles' );

		// Add post thumbnails
		// add_theme_support( 'post-thumbnails', array( 'post' ) );

		// Add responsive embedded content
		// add_theme_support( 'responsive-embeds' );

		// Add editor styles
		// add_theme_support( 'editor-styles' );

		// add_theme_support( 'custom-spacing' );

		// add_editor_style( 'style.css' );

	}

	public function bones_theme_load_favicons()
	{
		print '<link rel="icon" href="' . get_theme_file_uri('assets/favicon/favicon.svg') . '" type="image/svg+xml">';
	}

	// public function bones_theme_editor_styles() {
	// 	wp_add_inline_style( 'wp-block-library', $this->bones_theme_get_font_face_styles() );
	// }

	// public function bones_theme_get_font_face_styles() {
	// 	return "
	// 	@font-face{
	// 		font-family: 'Source Serif Pro';
	// 		font-weight: 200 900;
	// 		font-style: normal;
	// 		font-stretch: normal;
	// 		font-display: swap;
	// 		src: url('" . get_theme_file_uri( 'assets/fonts/SourceSerif4Variable-Roman.ttf.woff2' ) . "') format('woff2');
	// 	}
	// 	";
	// }

	// public function bones_theme_preload_webfonts() {
	// 	print '<link rel="preload" href="' . esc_url( get_theme_file_uri( 'assets/fonts/SourceSerif4Variable-Roman.ttf.woff2' ) ) . '" as="font" type="font/woff2" crossorigin>';
	// }

	public function bones_name_register_block_styles()
	{
		// Media & Text
		// register_block_style( 'core/media-text', [
		// 	'name' => 'stacked',
		// 	'label' => __( 'Stacked', 'bones_name' )
		// ] );

		// Cover
		// register_block_style( 'core/cover', [
		//   'name' => 'banner-reversed',
		//   'label' => __( 'Reversed', 'bones_name' ),
		// ] );

		// Columns
		// register_block_style( 'core/columns', [
		//   'name' => 'no-bottom-margin',
		//   'label' => __( 'No bottom margin', 'bones_name' ),
		// ] );

		// Buttons
		// register_block_style( 'core/button', [
		//   'name' => 'play',
		//   'label' => __( 'Play', 'bones_name' ),
		// ] );
	}

	public function bones_theme_enqueue_block_variations()
	{
		wp_enqueue_script(
			'bones-theme-enqueue-block-variations',
			get_template_directory_uri() . '/assets/js/variations.js',
			['wp-blocks', 'wp-dom-ready'],
			wp_get_theme()->get('Version'),
			false
		);
	}

	// public function update_gallery_styles( $styles ) {
	// 	$regex = '/(.wp-block-gallery[\S\w]*)/i';
	// 	return preg_replace( $regex, '${1}:not(.is-style-gallery-slider) ', $styles );
	// }

	// public function update_styles() {
	// 	// Extends upon wp-includes/script-loader.php/wp_maybe_inline_styles()
	// 	global $wp_styles;
	// 	if( isset( $wp_styles->registered['wp-block-gallery'] ) ) {
	// 		// `src` is set to false when it's already inlined
	// 		if( $wp_styles->registered['wp-block-gallery']->src !== false ) {
	// 			// based on code from inclues `wp_maybe_inline_styles` line:2818
	// 			$css = file_get_contents( $wp_styles->registered['wp-block-gallery']->extra['path'] );

	// 			// update relative urls
	// 			$css = _wp_normalize_relative_css_links( $css, $wp_styles->registered['wp-block-gallery']->src );

	// 			// set `src` to `false` and add styles inline
	// 			$wp_styles->registered[ 'wp-block-gallery' ]->src = false;
	// 			if ( empty( $wp_styles->registered[ 'wp-block-gallery' ]->extra['after'] ) ) {
	// 				$wp_styles->registered[ 'wp-block-gallery' ]->extra['after'] = array();
	// 			}
	// 			array_unshift( $wp_styles->registered[ 'wp-block-gallery' ]->extra['after'], $css );
	// 		}

	// 		// update `src` using regex to exclude our `.is-style-gallery-slider` class 
	// 		if( isset( $wp_styles->registered['wp-block-gallery']->extra['after'] ) ) {
	// 			$wp_styles->registered['wp-block-gallery']->extra['after'] = array_map( [ $this, 'update_gallery_styles' ], $wp_styles->registered['wp-block-gallery']->extra['after'] );
	// 		}	
	// 	}
	// }
}

// Init
new BoneThemeInit();
<?php
	// Require the composer autoload for getting conflict-free access to enqueue
	require_once __DIR__ . '/vendor/autoload.php';

	// Other functions
	require get_template_directory() . '/inc/block-patterns.php';
	// WEI Images tools
	require get_template_directory() . '/inc/images.php';
	// Extra tools
	require get_template_directory() . '/inc/tools.php';

	// Do stuff through this plugin
	class BoneThemeInit {
		public $enqueue;

		public function __construct() {
			$theme_version = wp_get_theme()->get( 'Version' );
			$version_string = is_string( $theme_version ) ? $theme_version : '1.0.0';

			// It is important that we init the Enqueue class right at the plugin/theme load time
			$this->enqueue = new \WPackio\Enqueue(
				// Name of the project, same as `appName` in wpackio.project.js
				'bonesTheme',
				// Output directory, same as `outputPath` in wpackio.project.js
				'dist',
				// Version of your plugin
				$version_string,
				// Type of your project, same as `type` in wpackio.project.js
				'theme',
				// Plugin location, pass false in case of theme.
				false,
				// Theme type
				'regular'
			);
			// Enqueue a few of our entry points
			add_action( 'wp_enqueue_scripts', [ $this, 'plugin_enqueue' ] );
			add_action( 'after_setup_theme', [ $this, 'bones_theme_support' ] );
			add_action( 'admin_init', [$this, 'bones_theme_editor_styles' ] );
			add_action( 'wp_head', [ $this, 'bones_theme_preload_webfonts' ] );
			add_action( 'init', [ $this, 'bones_name_register_block_styles' ], 100 );
		}

		public function plugin_enqueue() {
			$this->enqueue->enqueue( 'app', 'main', [] );

			// Inline styles for fonts
			wp_add_inline_style( 'bones-theme-style', $this->bones_theme_get_font_face_styles() );
		}
		
		public function bones_theme_support() {
			// Add support for block styles.
			add_theme_support( 'wp-block-styles' );

			// Add post thumbnails
			add_theme_support( 'post-thumbnails', array( 'post' ) );

			// Add responsive embedded content
			add_theme_support( 'responsive-embeds' );
			
			// Add editor styles
			add_theme_support( 'editor-styles' );

			add_theme_support( 'custom-spacing' );

			// add_editor_style( 'style.css' );

			// Enqueue editor styles.
			$assets = $this->enqueue->getAssets( 'app', 'main', [
				'js' => true,
				'css' => true,
				'js_dep' => [],
				'css_dep' => [],
				'in_footer' => true,
				'media' => 'all',
			] );

			if( !empty( $assets['css' ] ) ) {
				foreach( $assets['css'] as $css ) {
					$url = str_replace( trailingslashit( get_template_directory_uri() ), '', $css['url'] );
					add_editor_style( $url );
				}
			}
		}

		public function bones_theme_editor_styles() {
			wp_add_inline_style( 'wp-block-library', $this->bones_theme_get_font_face_styles() );
		}

		public function bones_theme_get_font_face_styles() {
			return "";
			// return "
			// @font-face{
			// 	font-family: 'Source Serif Pro';
			// 	font-weight: 200 900;
			// 	font-style: normal;
			// 	font-stretch: normal;
			// 	font-display: swap;
			// 	src: url('" . get_theme_file_uri( 'assets/fonts/SourceSerif4Variable-Roman.ttf.woff2' ) . "') format('woff2');
			// }
			// ";
		}

		public function bones_theme_preload_webfonts() {
			// print '<link rel="preload" href="' . esc_url( get_theme_file_uri( 'assets/fonts/SourceSerif4Variable-Roman.ttf.woff2' ) ) . '" as="font" type="font/woff2" crossorigin>';
		}

		public function bones_name_register_block_styles() {
			// Media & Text
			register_block_style( 'core/media-text', [
				'name' => 'stacked',
				'label' => __( 'Stacked', 'bones_name' )
			] );
	
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
			// register_block_style( 'core/columns', [
			//   'name' => 'columns-border',
			//   'label' => __( 'Columns border', 'bones_name' ),
			// ] );
	
			// Gallery
			// register_block_style( 'core/gallery', [
			//   'name' => 'gallery-slider',
			//   'label' => __( 'Gallery Slider', 'bones_name' ),
			// ] );
	
			// Buttons
			// register_block_style( 'core/button', [
			//   'name' => 'play',
			//   'label' => __( 'Play', 'bones_name' ),
			// ] );
		}
	}

	// Init
	new BoneThemeInit();
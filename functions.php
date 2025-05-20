<?php

	/**
	 * Bones Theme
	 */

	if ( ! defined( 'ABSPATH' ) )
		exit;

	require get_template_directory() . '/inc/vite-assets.php'; // vite-related functions
	require get_template_directory() . '/inc/tools.php';

	// Declutter
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );

	// Actions
	add_action( 'wp_head', 'theme_output_js_data', 5 );
	add_action( 'current_screen', 'bones_theme_add_editor_styles' );
	// add_action( 'wp_head', 'theme_fonts', 20 );

	// Entry Points
	function bones_theme_entry_points(): array {
		return [ 
			'src/index.js',
			'src/style.scss',
		];
	}

	// Inline Data
	function theme_output_js_data() {
		$data = [ 
			'ajax_url' => admin_url( 'admin-ajax.php' ),
		];

		print "<script type=\"text/javascript\">const phpData = " . wp_json_encode( $data ) . ";</script>";
	}

	// Fonts
	// function theme_fonts() {
	// 	print '<link rel="preconnect" href="https://fonts.googleapis.com">';
	// 	print '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
	// 	print '<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">';
	// }

	// Load Editor Styles
	function bones_theme_add_editor_styles( WP_Screen $screen ) {
		if ( $screen->base !== 'post' ) {
			return;
		}
		
		$main_entry = 'src/index.js';

		try {
			$frontend_config = bones_theme_get_frontend_config(); // shared variables between js and php
			$manifest = theme_get_vite_manifest_data( $frontend_config['distFolder'] );// vite manifest
			$css_files = bones_theme_get_styles_for_entry( $main_entry, $manifest );
			if ( pathinfo( $manifest[ $main_entry ]['file'], PATHINFO_EXTENSION ) === 'css' ) {
				$css_files[] = $manifest[ $main_entry ]['file']; // add if your entry is css-only
			}

			foreach ( $css_files as $css_file ) {
				add_editor_style( "{$frontend_config['distFolder']}/$css_file" ); // path relative to the theme!
			}
		} catch (Exception $e) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions -- intentional trigger_error for admin area
			trigger_error( $e->getMessage(), E_USER_WARNING );// don't break the entire admin page
		}
	}
<?php

add_filter( 'script_loader_tag', 'theme_modify_script_tag_for_modules', 15, 3 );
add_action( 'wp_enqueue_scripts', 'theme_enqueue_vite_assets' );
add_action( 'wp_head', 'theme_add_modulepreload_links', 15 );

// Main function that handles dynamic assets. It relies on the function (`theme_get_entry_points_for_current_page()`
// by default) defined in the theme
function theme_enqueue_vite_assets(): void {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- to be used in any theme
	$entry_points_func = apply_filters( 'theme_assets_entry_points_function', 'theme_get_entry_points_for_current_page' );
	$entry_points = call_user_func( $entry_points_func );
	$is_dev_mode = theme_is_dev_server();
	$frontend_config = theme_get_frontend_config();

	$scripts_queue = [];
	$styles_queue = [];

	error_log( "is_dev_mode: $is_dev_mode", 0 );

	// Dev (assets from vite dev server (only entrypoints for current page))
	if ( $is_dev_mode ) {
		// There is no @vite/client script here because it's handled by vite-plugin-browser-sync
		foreach ( $entry_points as $entry_point ) {
			$scripts_queue[] = $entry_point;
		}
	}

	

	// Prod
	if ( ! $is_dev_mode ) {
		try {
			$manifest = theme_get_vite_manifest_data( $frontend_config['distFolder'] );
		} catch (Exception $e) {
			wp_die( $e->getMessage() );
		}

		// process each entry point for current page and add its assets to the queue(s)
		foreach ( $entry_points as $entry_point ) {
			if ( ! isset( $manifest[ $entry_point ] ) )
				continue;

			$entry_styles = theme_get_styles_for_entry(
				$entry_point,
				$manifest
			);
			$styles_queue = array_merge( $styles_queue, $entry_styles );

			// Main entry point
			if ( pathinfo( $manifest[ $entry_point ]['file'], PATHINFO_EXTENSION ) === 'js' ) {
				// Only the entrypoints are added here
				$scripts_queue[] = $manifest[ $entry_point ]['file']; // js entry
			} else {
				$styles_queue[] = $manifest[ $entry_point ]['file']; // css-only entry
			}

		}
	}

	$theme_folder = get_template();
	$prod_assets_folder_url = "/wp-content/themes/$theme_folder/{$frontend_config['distFolder']}";
error_log( print_r( $entry_points, true ), 0 );
	// Queued assets
	foreach ( array_unique( $styles_queue ) as $css_file ) { // CSS
		error_log( "$prod_assets_folder_url/$css_file", 0 );
		wp_enqueue_style(
			$css_file,
			"$prod_assets_folder_url/$css_file",
			[],
			null
		);
	}

	foreach ( array_unique( $scripts_queue ) as $js_file ) { // JS
		$asset_path = $is_dev_mode
			? "http://localhost:{$frontend_config['viteServerPort']}/$js_file"
			: "$prod_assets_folder_url/$js_file";

		wp_enqueue_script(
			$js_file,
			$asset_path,
			[],
			null,
			true
		);
	}
}

// Add type="module" and crossorigin to vite scripts
function theme_modify_script_tag_for_modules( $tag, $handle ): string {
	// Dev assets
	if ( strpos( $handle, 'assets' ) !== false || strpos( $handle, 'src' ) !== false ) {
		$tag = preg_replace( '/ type=([\'"])[^\'"]+\1/', '', $tag );
		$tag = str_replace( ' src', ' type="module" crossorigin src', $tag );
	}
	return $tag;
}

// Add 'modulepreload' directives to <head>, because vite doesn't handle wp templates. Function relies on the function
// (`theme_get_entry_points_for_current_page()` by default) defined in the theme
// https://vitejs.dev/guide/features.html#preload-directives-generation
function theme_add_modulepreload_links(): void {
	if ( theme_is_dev_server() )
		return; // 'modulepreload's are required only for prod

	$frontend_config = theme_get_frontend_config(); // shared vars between js and php
	try {
		$manifest = theme_get_vite_manifest_data( $frontend_config['distFolder'] ); // vite manifest
	} catch (Exception $e) {
		wp_die( $e->getMessage() );
	}

	$theme = get_template();
	$prod_assets_folder_url = "/wp-content/themes/$theme/{$frontend_config['distFolder']}";
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- to be used in any theme
	$entry_points_func = apply_filters( 'theme_assets_entry_points_function', 'theme_get_entry_points_for_current_page' );
	$entry_points = call_user_func( $entry_points_func ); // function must be defined in the theme

	$urls = [];
	foreach ( $entry_points as $entry_point ) {
		$urls = array_merge(
			$urls,
			theme_get_assets_from_dependencies( $entry_point, $manifest, 'js' )
		);
	}

	$preload_html = '';
	foreach ( array_unique( $urls ) as $url ) { // no 'as="script"' attr because it is default
		$preload_html .= "<link rel='modulepreload' href='$prod_assets_folder_url/$url' />\r\n";
	}
	echo $preload_html;
}

/* Helpers */

// Returns a config with variables shared between js and php. Config is a part of the theme so the function doesn't
// check if file exists

function theme_get_frontend_config(): array {
	return json_decode(
		file_get_contents( get_template_directory() . "/frontend-config.json" ),
		true
	);
}

// Returns an array with build data from manifest.json.
function theme_get_vite_manifest_data( string $folder ): array {
	$manifest_path = get_template_directory() . "/$folder/.vite/manifest.json";
	$resolved_manifest_path = realpath( $manifest_path );

	if (
		! is_file( $resolved_manifest_path ) ||
		! is_readable( $resolved_manifest_path )
	) {
		throw new Exception( "Can't load vite manifest file: $manifest_path" );
	}

	return json_decode(
		file_get_contents( $resolved_manifest_path ),
		true
	);
}

function theme_get_all_headers() {
	if( function_exists( 'getallheaders' ) ) {
		$headers = getallheaders();
	} 
	else if( !is_array( $_SERVER ) ) {
		$headers = $_SERVER;
	}

	if( empty( $headers ) ) {
		return [];
	}

	$return = [];
	foreach ( $_SERVER as $name => $value ) {
		if( substr( $name, 0, 5 ) === 'HTTP_' ) {
			$key = str_replace(' ', '-', strtoupper(strtolower(str_replace('_', ' ', substr($name, 5)))));
			$return[$key] = $value;
		}
	}
	return $return;
}

// Checks if current environment is dev (by BrowserSync custom header)
function theme_is_dev_server(): bool {
	$headers = theme_get_all_headers();
	
	if ( empty( $headers ) ) { // apache specific!, if you use nginx add a polyfill
		return false;
	}

	
	$frontend_config = theme_get_frontend_config();
	$proxy_header_name = $frontend_config['devModeProxyHeader']; // set by browserSync in vite.config.js
	
	if ( isset( $headers[ strtoupper($proxy_header_name) ] ) ) { // value is not important, check only for the presence of the header
		return true;
	}
	return false;
}

// The function recursively searches for dependencies of the $entry ('css' and 'file' of the passed $entry are not included)
function theme_get_assets_from_dependencies( string $entry, array $manifest, string $asset_type ): array {
	if ( ! isset( $manifest[ $entry ]['imports'] ) )
		return [];

	$assets = [];
	foreach ( $manifest[ $entry ]['imports'] as $imports_entry ) {
		if ( isset( $manifest[ $imports_entry ]['imports'] ) ) {
			$nested_assets = theme_get_assets_from_dependencies(
				$imports_entry,
				$manifest,
				$asset_type
			);
			$assets[] = $nested_assets;
		}
		// add the main asset(s) only after its dependencies. ['css'] is always an array, ['file'] is always a string
		if ( $asset_type === 'css' && isset( $manifest[ $imports_entry ]['css'] ) ) {
			$assets[] = $manifest[ $imports_entry ]['css'];
		} elseif ( $asset_type === 'js' && isset( $manifest[ $imports_entry ]['file'] ) ) {
			$assets[] = $manifest[ $imports_entry ]['file'];
		}
	}
	return $assets;
}

// Collects all the css files for the $entry (and from all its dependencies) in the right order (except for the main
// $entry 'file' if $entry is css-only)
function theme_get_styles_for_entry( string $entry, array $manifest ): array {
	$styles = theme_get_assets_from_dependencies( $entry, $manifest, 'css' );

	// css for current entrypoint if exist ([] in 'css' key), added after all styles of the current entry dependencies
	if ( isset( $manifest[ $entry ]['css'] ) ) {
		$styles = array_merge( $styles, $manifest[ $entry ]['css'] );
	}
	return $styles;
}

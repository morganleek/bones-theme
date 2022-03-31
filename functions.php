<?php
	// Require the composer autoload for getting conflict-free access to enqueue
	require_once __DIR__ . '/vendor/autoload.php';

	// Do stuff through this plugin
	class BoneThemeInit {
		public $enqueue;

		public function __construct() {
			// It is important that we init the Enqueue class right at the plugin/theme load time
			$this->enqueue = new \WPackio\Enqueue(
				// Name of the project, same as `appName` in wpackio.project.js
				'bonesTheme',
				// Output directory, same as `outputPath` in wpackio.project.js
				'dist',
				// Version of your plugin
				'1.0.0',
				// Type of your project, same as `type` in wpackio.project.js
				'theme',
				// Plugin location, pass false in case of theme.
				false,
				// Theme type
				'regular'
			);
			// Enqueue a few of our entry points
			add_action( 'wp_enqueue_scripts', [ $this, 'plugin_enqueue' ] );
		}

		public function plugin_enqueue() {
			$this->enqueue->enqueue( 'app', 'main', [] );
		// 	// Enqueue files[0] (name = app) - entryPoint mobile
		//	$this->enqueue->enqueue( 'app', 'mobile', [] );
		// 	// Enqueue files[1] (name = foo) - entryPoint main
		// 	// $this->enqueue->enqueue( 'foo', 'main', [] );
		// 	// Enqueue files[2] (name = reactapp) - entryPoint main
		// 	// $this->enqueue->enqueue( 'reactapp', 'main', [] );
		}
	}


	// Init
	new BoneThemeInit();
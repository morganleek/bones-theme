<?php
// This file is generated. Do not modify it manually.
return array(
	'expander' => array(
		'$schema' => 'https://raw.githubusercontent.com/WordPress/gutenberg/trunk/schemas/json/block.json',
		'apiVersion' => 3,
		'name' => 'bones-blocks/expander',
		'version' => '0.1.0',
		'title' => 'Expander',
		'category' => 'widgets',
		'icon' => 'arrow-down-alt2',
		'description' => 'Accordion style expander with a header and collapsible body',
		'example' => array(
			
		),
		'attributes' => array(
			'initiallyOpen' => array(
				'type' => 'boolean',
				'default' => false
			)
		),
		'supports' => array(
			'html' => false,
			'align' => true,
			'spacing' => array(
				'margin' => true,
				'padding' => true
			),
			'interactivity' => true
		),
		'textdomain' => 'bones-blocks',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScriptModule' => 'file:./view.js'
	),
	'expander-body' => array(
		'$schema' => 'https://raw.githubusercontent.com/WordPress/gutenberg/trunk/schemas/json/block.json',
		'apiVersion' => 3,
		'name' => 'bones-blocks/expander-body',
		'version' => '0.1.0',
		'title' => 'Expander Body',
		'category' => 'widgets',
		'icon' => 'text',
		'description' => 'Collapsible body of an Expander',
		'parent' => array(
			'bones-blocks/expander'
		),
		'supports' => array(
			'html' => false,
			'reusable' => false,
			'spacing' => array(
				'margin' => true
			),
			'interactivity' => true
		),
		'textdomain' => 'bones-blocks',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'expander-header' => array(
		'$schema' => 'https://raw.githubusercontent.com/WordPress/gutenberg/trunk/schemas/json/block.json',
		'apiVersion' => 3,
		'name' => 'bones-blocks/expander-header',
		'version' => '0.1.0',
		'title' => 'Expander Header',
		'category' => 'widgets',
		'icon' => 'heading',
		'description' => 'Clickable header of an Expander',
		'parent' => array(
			'bones-blocks/expander'
		),
		'supports' => array(
			'html' => false,
			'reusable' => false,
			'spacing' => array(
				'margin' => true,
				'padding' => true
			),
			'interactivity' => true
		),
		'textdomain' => 'bones-blocks',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php'
	),
	'overlay-button' => array(
		'$schema' => 'https://raw.githubusercontent.com/WordPress/gutenberg/trunk/schemas/json/block.json',
		'apiVersion' => 3,
		'name' => 'bones-blocks/overlay-button',
		'version' => '0.1.0',
		'title' => 'Overlay Button',
		'category' => 'design',
		'icon' => 'button',
		'description' => 'A button that opens a Navigation Overlay template part when clicked.',
		'keywords' => array(
			'button',
			'overlay',
			'modal',
			'popup',
			'dialog'
		),
		'textdomain' => 'bones-blocks',
		'attributes' => array(
			'text' => array(
				'type' => 'rich-text',
				'source' => 'rich-text',
				'selector' => 'button',
				'role' => 'content'
			),
			'title' => array(
				'type' => 'string',
				'source' => 'attribute',
				'selector' => 'button',
				'attribute' => 'title',
				'role' => 'content'
			),
			'overlay' => array(
				'type' => 'string'
			),
			'placeholder' => array(
				'type' => 'string'
			),
			'backgroundColor' => array(
				'type' => 'string'
			),
			'textColor' => array(
				'type' => 'string'
			),
			'gradient' => array(
				'type' => 'string'
			)
		),
		'supports' => array(
			'anchor' => true,
			'html' => false,
			'align' => false,
			'alignWide' => false,
			'reusable' => false,
			'color' => array(
				'__experimentalSkipSerialization' => true,
				'gradients' => true,
				'__experimentalDefaultControls' => array(
					'background' => true,
					'text' => true
				)
			),
			'typography' => array(
				'__experimentalSkipSerialization' => array(
					'fontSize',
					'lineHeight',
					'textAlign',
					'fontFamily',
					'fontWeight',
					'fontStyle',
					'textTransform',
					'textDecoration',
					'letterSpacing'
				),
				'fontSize' => true,
				'lineHeight' => true,
				'textAlign' => true,
				'__experimentalFontFamily' => true,
				'__experimentalFontWeight' => true,
				'__experimentalFontStyle' => true,
				'__experimentalTextTransform' => true,
				'__experimentalTextDecoration' => true,
				'__experimentalLetterSpacing' => true,
				'__experimentalWritingMode' => true,
				'__experimentalDefaultControls' => array(
					'fontSize' => true
				)
			),
			'shadow' => array(
				'__experimentalSkipSerialization' => true
			),
			'spacing' => array(
				'__experimentalSkipSerialization' => true,
				'padding' => array(
					'horizontal',
					'vertical'
				),
				'__experimentalDefaultControls' => array(
					'padding' => true
				)
			),
			'__experimentalBorder' => array(
				'color' => true,
				'radius' => true,
				'style' => true,
				'width' => true,
				'__experimentalSkipSerialization' => true,
				'__experimentalDefaultControls' => array(
					'color' => true,
					'radius' => true,
					'style' => true,
					'width' => true
				)
			),
			'interactivity' => true
		),
		'styles' => array(
			array(
				'name' => 'fill',
				'label' => 'Fill',
				'isDefault' => true
			),
			array(
				'name' => 'outline',
				'label' => 'Outline'
			)
		),
		'selectors' => array(
			'root' => '.wp-block-button .wp-block-button__link',
			'typography' => array(
				'writingMode' => '.wp-block-button'
			)
		),
		'editorScript' => 'file:./index.js',
		'editorStyle' => array(
			'wp-block-button-editor',
			'file:./index.css'
		),
		'style' => array(
			'wp-block-button',
			'file:./style-index.css'
		),
		'render' => 'file:./render.php',
		'viewScriptModule' => 'file:./view.js'
	),
	'site-search' => array(
		'$schema' => 'https://raw.githubusercontent.com/WordPress/gutenberg/trunk/schemas/json/block.json',
		'apiVersion' => 3,
		'name' => 'bones-blocks/site-search',
		'version' => '0.1.0',
		'title' => 'Site Search',
		'category' => 'widgets',
		'icon' => 'search',
		'description' => 'Site search via AJAX',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false,
			'align' => true,
			'interactivity' => true
		),
		'textdomain' => 'bones-blocks',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScriptModule' => 'file:./view.js',
		'render' => 'file:./render.php'
	),
	'site-wrapper' => array(
		'$schema' => 'https://raw.githubusercontent.com/WordPress/gutenberg/trunk/schemas/json/block.json',
		'apiVersion' => 3,
		'name' => 'bones-blocks/site-wrapper',
		'version' => '0.1.0',
		'title' => 'Site Wrapper',
		'category' => 'widgets',
		'icon' => 'welcome-widgets-menus',
		'description' => 'AJAX Wrapper',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false,
			'align' => true,
			'spacing' => array(
				'margin' => true,
				'padding' => true
			),
			'interactivity' => true
		),
		'textdomain' => 'bones-blocks',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScriptModule' => 'file:./view.js'
	)
);

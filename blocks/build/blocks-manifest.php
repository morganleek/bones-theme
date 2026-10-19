<?php
// This file is generated. Do not modify it manually.
return array(
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

<?php

add_action('wp_enqueue_scripts', 'true_child_styles');

function true_child_styles()
{

	wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array(), null);
}

add_action('wp_enqueue_scripts', 'wptuts_scripts_with_jquery');






add_action('init', 'register_custom_jquery');
function register_custom_jquery()
{
	wp_deregister_script('jquery');

	wp_register_script(
		'jquery',
		'https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js',
		array(),
		'1.6.1'
	);

	wp_register_script(
		'my-script',
		get_stylesheet_directory_uri() . '/js/javascript.js',
		array(),
		'1.0'
	);
}
	add_filter( 'widget_text', 'do_shortcode' );

add_action('wp_enqueue_scripts', 'add_js_to_page');
function add_js_to_page()
{
	wp_enqueue_script('jquery');

	wp_enqueue_script('my-script');
}



add_shortcode( 'r_test', 'shortcode_callback' );

function shortcode_callback( $atts,$content ) {
	$atts = shortcode_atts( array(
		'title' => 'title',
	), $atts, 'r_test' );

	return  esc_html($atts['title']).  '<div style="white-space:pre-wrap;">'. $content .'</div>';
}





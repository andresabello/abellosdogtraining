<?php

/**
 * Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package UiCore
 */
defined('ABSPATH') || exit;

require __DIR__ . '/includes/PostTypes/ComponentPostType.php';
require __DIR__ . '/includes/MetaBoxes/ComponentOptionsField.php';
require __DIR__ . '/includes/Shortcodes/Components.php';
require __DIR__ . '/helpers.php';


add_action('wp_enqueue_scripts', 'ui_child_enqueue_styles');
function ui_child_enqueue_styles()
{
	if (!class_exists('\UiCore\Core')) {
		wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
	}
	wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css');
}

/* YOU CAN START EDITING HERE! */
/*
 * a list of complete hooks and filters can be found here
 * https://support.uicore.co/help-center/articles/14/13/42/hooks-and-filters
 *
*/

add_action('init', function () {
	$theme = wp_get_theme();
	(new ComponentPostType($theme['Name']))->handle();
});


add_shortcode('component', [
	Components::class,
	'render'
]);

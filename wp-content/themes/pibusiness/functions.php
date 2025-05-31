<?php

use App\Menu\MenuBuilder;
use App\PostTypes\ComponentPostType;
use App\PostTypes\TabbedContentPostType;
use App\ThemeStarter;
use App\Widgets\QuoteForm;
use App\Widgets\ContactForm;
use App\Widgets\CurrencyConverter;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/includes/helpers.php';

define('THEME_PATH', get_template_directory());
const ASSETS = THEME_PATH . '/assets';
const IMAGES = THEME_PATH . "/assets/img";

add_action('init', function () {
    $theme = wp_get_theme();
    (new ThemeStarter($theme['Name'], $theme['Version']))->handle();
    (new ComponentPostType($theme['Name']))->handle();
    (new TabbedContentPostType($theme['Name']))->handle();
});


if (function_exists('register_sidebar')) {
    register_sidebar([
        'name' => __('Primary Sidebar', 'primary-sidebar'),
        'id' => 'primary-widget-area',
        'description' => __('The primary widget area', 'dir'),
        'before_widget' => '<div class="my-5">',
        'after_widget' => "</div>",
        'before_title' => '<h3 class="mb-3 text-center">',
        'after_title' => '</h3>',
    ]);
}

if (function_exists('register_nav_menus')) {
    register_nav_menus(['main' => 'Main Nav']);
}

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

function my_theme_wrapper_start()
{
    echo '<div class="row"><div class="col-xl-12">';
}

function my_theme_wrapper_end()
{
    echo '</div></div>';
}

add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);


if (function_exists('register_sidebar')) {
    register_sidebar([
        'name' => 'Footer Left',
        'id' => 'footer-left-widget',
        'description' => 'Left Footer widget position.',
        'before_widget' => '<div id="%1$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>'
    ]);

    register_sidebar([
        'name' => 'Footer Center',
        'id' => 'footer-center-widget',
        'description' => 'Centre Footer widget position.',
        'before_widget' => '<div id="%1$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>'
    ]);

    register_sidebar([
        'name' => 'Footer Right',
        'id' => 'footer-right-widget',
        'description' => 'Right Footer widget position.',
        'before_widget' => '<div id="%1$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>'
    ]);


}

//Add support for WP 3.0 features, thumbnails etc
add_theme_support('woocommerce');
add_theme_support('post-thumbnails');
add_theme_support('nav-menus');
add_theme_support('custom-background');


function getMenu()
{
    $menu = MenuBuilder::build('Menu');
    set_query_var('menu', $menu);
    ob_start();
    get_template_part('menu/main');
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}

add_action('widgets_init', function () {
    register_widget(ContactForm::class);
    register_widget(QuoteForm::class);
    register_widget(CurrencyConverter::class);
});
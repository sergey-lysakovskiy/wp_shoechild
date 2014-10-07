<?php

require('includes/globals.php');
require('includes/shoestrap-overrides.php');
require('includes/parallax.php');
require('includes/shoestrap-options-navbar.php');
require('includes/shoestrap-options-header.php');
require('includes/menu-anchor-links.php');
require('includes/cpt-override.php');
require('includes/cpt-options-section.php');
require('includes/cpt-images-section.php');
//require( 'includes/acf-values-slider.php');

//require( 'wptuts-editor-buttons/wptuts.php' );

add_action('wp_enqueue_scripts', 'shoestrap_styles');

function shoestrap_styles() {
    wp_register_script('jquery.visible',get_stylesheet_directory_uri() . '/assets/js/jquery.visible.min.js',array('jquery'));
    wp_enqueue_script('jquery.visible');

    wp_register_script('waypoints',get_stylesheet_directory_uri() . '/assets/js/waypoints.min.js',array('jquery'));
    wp_enqueue_script('waypoints');
    
    wp_register_script('isotope',get_stylesheet_directory_uri() . '/assets/js/isotope.pkgd.min.js');
    wp_enqueue_script('isotope');

    wp_register_script('cpt-masonry-enable',get_stylesheet_directory_uri() . '/assets/js/cpt-masonry-enable.js',array('jquery','isotope'));
    wp_enqueue_script('cpt-masonry-enable');

    wp_register_script('imagesloaded',get_stylesheet_directory_uri() . '/assets/js/imagesloaded.pkgd.min.js');
    wp_enqueue_script('imagesloaded');

    wp_register_script('anchors-jump',get_stylesheet_directory_uri() . '/assets/js/anchors-jump.js',array('jquery','waypoints'));
    wp_enqueue_script('anchors-jump');

    wp_register_script('theme',get_stylesheet_directory_uri() . '/assets/js/theme.js',array('jquery','isotope'));
    wp_enqueue_script('theme');

    wp_enqueue_style( 'theme', get_stylesheet_uri(), false, null );
}

add_action( 'admin_enqueue_scripts', 'load_admin_scripts' );

function load_admin_scripts () {
    wp_register_script('values-slider', get_stylesheet_directory_uri() . '/assets/js/values-slider.js',array('jquery','jquery.visible'));
    wp_enqueue_script('values-slider');
}

add_action( 'after_setup_theme', 'shoestrap_after_setup' );

function shoestrap_after_setup () {
    add_editor_style(get_stylesheet_directory_uri() . '/assets/css/editor-style.css');
}

/*add_filter('mce_buttons_2', 'gk_activate_styleselect');
function gk_activate_styleselect($buttons) {
   array_unshift( $buttons, 'styleselect' );
   return $buttons;
}*/

// expanding bootstrap functionality by adding XL sheme (1400px+ screens)
add_filter( 'shoestrap_compiler', 'theme_less_styles' );
function theme_less_styles( $bootstrap ) {
    return $bootstrap . '
    @import "' . get_stylesheet_directory() . '/assets/less/xl-size.less";';

}
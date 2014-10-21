<?php

require('includes/globals.php');
require('includes/shoestrap-overrides.php');
require('includes/parallax.php');
require('includes/shoestrap-options-navbar.php');
require('includes/shoestrap-options-header.php');
require('includes/shoestrap-options-layout.php');
require('includes/shoestrap-options-footer.php');
require('includes/menu-anchor-links.php');
require('includes/cpt-override.php');
require('includes/cpt-options-section.php');
require('includes/cpt-images-section.php');

require('includes/widget-logo.php');
require('includes/widget-phone.php');

//require( 'wptuts-editor-buttons/wptuts.php' );

add_action('wp_enqueue_scripts', 'shoestrap_styles');

function shoestrap_styles() {
    wp_register_script('jquery.visible',get_stylesheet_directory_uri() . '/assets/js/jquery.visible.min.js',array('jquery'));
    wp_enqueue_script('jquery.visible');

    /* anchor waypoints */
    wp_register_script('waypoints',get_stylesheet_directory_uri() . '/assets/js/waypoints.min.js',array('jquery'));
    wp_enqueue_script('waypoints');
    
    /* mansory style */
    wp_register_script('isotope',get_stylesheet_directory_uri() . '/assets/js/isotope.pkgd.min.js');
    wp_enqueue_script('isotope');

    /* mousewheel library */
    wp_register_script('jquery-mousewheel',get_stylesheet_directory_uri() . '/assets/js/jquery.mousewheel.min.js',array('jquery'));
    wp_enqueue_script('jquery-mousewheel');

    /* smooth scroll */
    wp_register_script('smooth-scroll',get_stylesheet_directory_uri() . '/assets/js/jquery.simplr.smoothscroll.js',array('jquery-mousewheel'));
    wp_enqueue_script('smooth-scroll');
    
    wp_register_script('jquery-scrollto',get_stylesheet_directory_uri() . '/assets/js/jquery.scrollTo-1.4.3.1.min.js',array('jquery'));
    wp_enqueue_script('jquery-scrollto');

    wp_register_script('jquery-easing',get_stylesheet_directory_uri() . '/assets/js/jquery.easing.1.3.js',array('jquery'));
    wp_enqueue_script('jquery-easing');

    wp_register_script('jquery-parallax',get_stylesheet_directory_uri() . '/assets/js/jquery.parallax-1.1.js',array('jquery'));
    wp_enqueue_script('jquery-parallax');

    wp_register_script('jquery-scrollorama',get_stylesheet_directory_uri() . '/assets/js/jquery.scrollorama.js',array('jquery'));
    wp_enqueue_script('jquery-scrollorama');

    wp_register_script('jquery-scrolldeck',get_stylesheet_directory_uri() . '/assets/js/jquery.scrolldeck.js',array('jquery','jquery-easing','jquery-scrollorama'));
    wp_enqueue_script('jquery-scrolldeck');
    

    
    wp_register_script('cpt-masonry-enable',get_stylesheet_directory_uri() . '/assets/js/cpt-masonry-enable.js',array('jquery','isotope'));
    wp_enqueue_script('cpt-masonry-enable');

    wp_register_script('imagesloaded',get_stylesheet_directory_uri() . '/assets/js/imagesloaded.pkgd.min.js');
    wp_enqueue_script('imagesloaded');

    wp_register_script('anchors-jump',get_stylesheet_directory_uri() . '/assets/js/anchors-jump.js',array('jquery','waypoints'));
    wp_enqueue_script('anchors-jump');

    wp_register_script('wc-quantity-loop',get_stylesheet_directory_uri() . '/assets/js/wc-quantity-loop.js',array('jquery'));
    wp_enqueue_script('wc-quantity-loop');

    wp_register_script('theme',get_stylesheet_directory_uri() . '/assets/js/theme.js',array('jquery','isotope','jquery-parallax'));
    wp_enqueue_script('theme');

    wp_enqueue_style( 'theme', get_stylesheet_uri(), false, null );

    wp_register_style('user',get_stylesheet_directory_uri() . '/userdata/css/user.css',array('shoestrap_css','theme'));
    wp_enqueue_style('user');
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

add_action( 'widgets_init', 'register_site_widgets' );

function register_site_widgets () {
    register_widget('LogoWidget');
    register_widget('PhoneWidget');
}

add_filter( 'admin_init' , 'phone_register_fields' );

function phone_register_fields() {
    register_setting( 'general', 'sitephone', 'esc_attr' );
    add_settings_field('sitephone', '<label for="sitephone">'.__('Phone' , 'phone' ).'</label>' , 'phone_fields_html' , 'general' );
}

function phone_fields_html() {
    $value = get_option( 'sitephone', '' );
    echo '<input type="text" id="sitephone" name="sitephone" value="' . $value . '" />';
}

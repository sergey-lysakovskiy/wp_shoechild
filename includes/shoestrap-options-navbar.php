<?php

add_filter('shoestrap_module_menus_styling_options_modifier','navbar_hide_option',10,1);

function navbar_hide_option ($args) {
    $hide = array (
        'title'     => __( 'Autohide navigation bar', 'shoestrap' ),
        'desc'      => __( 'Show navigation bar only when the header is scrolled off the screen', 'shoestrap' ),
        'id'        => 'navbar_autoshow',
        'default'   => 0,
        'type'      => 'switch',
    );
    
    $args[] = $hide;

    return $args;
}

add_action('wp_enqueue_scripts', 'navbar_hide_script');

function navbar_hide_script() {
    global $ss_settings;

    if ($ss_settings['navbar_autoshow']) {
        wp_register_script('navbar-hide',get_stylesheet_directory_uri() . '/assets/js/navbar-hide.js',array('jquery'));
        wp_enqueue_script('navbar-hide');

        wp_register_style('navbar-hide',get_stylesheet_directory_uri() . '/assets/css/navbar-hide.css',array('shoestrap_css'));
        wp_enqueue_style('navbar-hide');
    }
}

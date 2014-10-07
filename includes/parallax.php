<?php

add_filter('shoestrap_module_background_options_modifier','background_parallax_option',10,1);

function background_parallax_option ($args) {
    $parallax = array(
        'title'     => __( 'Enable Parallax effect for background', 'shoestrap' ),
        'desc'      => __( '', 'shoestrap' ),
        'id'        => 'parallax_effect',
        'default'   => 0,
        'type'      => 'switch',
    );

    array_push ($args,$parallax);
    
    return $args;
}

add_filter('body_class', 'background_parallax_body_class');

function background_parallax_body_class($classes) {
    global $ss_settings;
    
    if ($ss_settings['parallax_effect']) $classes[] = 'parallax';
    return $classes;
}

add_action('wp_enqueue_scripts', 'background_parallax_script');

function background_parallax_script() {
    wp_register_script('parallax',get_stylesheet_directory_uri() . '/assets/js/parallax.js',array('jquery'));
    wp_enqueue_script('parallax');
}


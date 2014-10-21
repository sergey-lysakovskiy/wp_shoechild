<?php

add_filter('shoestrap_module_layout_options_modifier','layout_extra_options',10,1);

function layout_extra_options ($args) {
    $max_width = array(
        'title'       => __( 'Max content width', 'shoestrap' ),
        'desc'        => __( 'Set max content width for layout', 'shoestrap' ),
        'id'          => 'max_width',
        'default'     => 0,
        'min'         => 0,
        'step'        => 1,
        'max'         => 2500,
        'edit'        => 1,
        'type'        => 'slider',
        'required'    => array('site_style','=','fluid'),
    );
    

    $args[] = $max_width;
    
    return $args;
}

add_action( 'wp_enqueue_scripts', 'layout_extra_styles',1000, 0 );

function layout_extra_styles() {
    global $ss_settings;
    
    if ($ss_settings['max_width']) {
        $max_width = $ss_settings['max_width']; 

        $custom_css = ".max-width-wrapper { max-width: ".$ss_settings['max_width']."px; margin: 0 auto; }";
        
        wp_add_inline_style( 'shoestrap_css', $custom_css );
    };
    
}


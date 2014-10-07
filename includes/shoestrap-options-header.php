<?php

add_filter('shoestrap_module_header_options_modifier','header_extra_options',10,1);

function header_extra_options ($args) {
    $links_color = array(
        'title'       => __( 'Header Links Color', 'shoestrap' ),
        'desc'        => __( 'Select the links color for your header. Default: #333333.', 'shoestrap' ),
        'id'          => 'header_a_color',
        'default'     => '#333333',
        'transparent' => false,
        'type'        => 'color',
        'required'    => array('header_toggle','=',array('1')),
    );
    

    $args[] = $links_color;
    
    return $args;
}

add_action( 'wp_enqueue_scripts', 'header_extra_styles',1000, 0 );

function header_extra_styles() {
    global $ss_settings;
    
    if ($ss_settings['header_a_color']) {
        $color = $ss_settings['header_a_color']; 
        $header_bg = $ss_settings['header_bg']; 

        if ( is_array( $ss_settings['header_bg'] ) ) {
            $bg = Shoestrap_Color::sanitize_hex( $ss_settings['header_bg']['background-color'] );
        } else {
            $bg = Shoestrap_Color::sanitize_hex( $ss_settings['header_bg'] );
        }

        $opacity  = ( intval( $ss_settings['header_bg_opacity'] ) ) / 100;

        $rgb      = Shoestrap_Color::get_rgb( $bg, true );
        
        
        $custom_css = "body .before-main-wrapper .header-wrapper a { color: {$color}; }";
        $custom_css .= "li.parent .nav-sublist { width:100%;";
        
        
        if ( $opacity < 1 && ! $ss_settings['header_bg']['background-image'] ) {
            $custom_css .= 'background: rgb(' . $rgb . '); background: rgba(' . $rgb . ', ' . $opacity . ');';
        } else {
            $custom_css .= 'background: '.$bg.';';
        }
        
        $custom_css .= '}';
        
        
        wp_add_inline_style( 'shoestrap_css', $custom_css );
    };
    
}


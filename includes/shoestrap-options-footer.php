<?php

add_filter('shoestrap_module_footer_options_modifier','footer_extra_options',10,1);

function footer_extra_options ($args) {
    $args[] = array(
        'title'       => __( 'Footer Links Color', 'shoestrap' ),
        'desc'        => __( 'Select the links color for your footer. Default: #333333.', 'shoestrap' ),
        'id'          => 'footer_a_color',
        'default'     => '#333333',
        'transparent' => false,
        'type'        => 'color',
    );
    
    $args[] = array (
        'title'     => __( 'Enable gradient background', 'shoestrap' ),
        'desc'      => __( 'Enable gradient background in footer', 'shoestrap' ),
        'id'        => 'footer_bg_gradient',
        'default'   => 0,
        'type'      => 'switch',
    );

    $args[] = array(
        'title'       => __( 'Gradient 2nd Color', 'shoestrap' ),
        'desc'        => __( 'Select 2nd Color for gradient background in footer', 'shoestrap' ),
        'id'          => 'footer_bg_color_2',
        'transparent' => true,
        'type'        => 'color',
        'required'    => array('footer_bg_gradient','=',array('1')),
    );

    return $args;
}

add_action( 'wp_enqueue_scripts', 'footer_extra_styles',1000, 0 );

function footer_extra_styles() {
    global $ss_settings;
    
    $custom_css;
    
    if ($ss_settings['footer_a_color']) {
        $color = $ss_settings['footer_a_color']; 
        
        $custom_css .= "#page-footer a { color: {$color}; }";
       
        
    };

    if ($ss_settings['footer_bg_gradient']) {
        $color_1 = $ss_settings['footer_background']; 
        $color_2 = $ss_settings['footer_bg_color_2']; 
        
        $custom_css .= "footer.content-info { background: {$color_1}; /* Old browsers */
            background: -moz-linear-gradient(top,  {$color_1} 0%, {$color_2} 100%); /* FF3.6+ */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,{$color_1}), color-stop(100%,{$color_2})); /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top,  {$color_1} 0%,{$color_2} 100%); /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(top,  {$color_1} 0%,{$color_2} 100%); /* Opera 11.10+ */
            background: -ms-linear-gradient(top,  {$color_1} 0%,{$color_2} 100%); /* IE10+ */
            background: linear-gradient(to bottom,  {$color_1} 0%,{$color_2} 100%); /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='{$color_1}', endColorstr='{$color_2}',GradientType=0 ); /* IE6-9 */
        }";
       
        
    };

    wp_add_inline_style( 'shoestrap_css', $custom_css );
    
}


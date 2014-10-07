<?php
add_action ('shoestrap_include_files','cpt_images_sections');

function cpt_images_sections() {
    if( !class_exists( 'ShoestrapCptImagesSections' ) ) {
        /**
        * Build the Admin section, settings etc.
        */

        class ShoestrapCptImagesSections {
            function __construct() {
                add_filter( 'redux/options/' . SHOESTRAP_OPT_NAME . '/sections', array( $this, 'options' ), 85 ); 
            }

            /*
             * The options
             */
            function options( $sections ) {
                global $ss_settings;
                
                $screen_large_desktop = isset( $ss_settings['screen_large_desktop'] ) ? filter_var( $ss_settings['screen_large_desktop'], FILTER_SANITIZE_NUMBER_INT ) : 1200;
                $post_types = get_post_types(array(),'objects');
                
                foreach ( $post_types as $key => $post_type ):
                    if($post_type->has_archive):
                        // Add a new section to redux
                        $section = array(
                            'title' => __( $post_type->labels->name . ' featured images', 'shoestrap' ),
                            'icon' => 'el-icon-chevron-right',
                            'subsection' => true,
                        );
                    
                    
                        $fields = apply_filters( 'shoestrap_module_featured_images_modifier', array(
                            array(
                                    'id'        => $key . '_help3',
                                    'title'     => __( 'Featured Images', 'shoestrap' ),
                                    'desc'      => __( 'Here you can select if you want to display the featured images in '.$post_type->labels->name.' archives and individual '.$post_type->labels->singular_name.'. You can select image sizes independently for archives and individual posts view.', 'shoestrap' ),
                                    'type'      => 'info',
                            ),
                            array(
                                    'title'     => __( 'Featured Images on Archives', 'shoestrap' ),
                                    'desc'      => __( 'Display featured Images on post archives ( such as categories, tags, month view etc ). Default: OFF.', 'shoestrap' ),
                                    'id'        => $key . '_feat_img_archive',
                                    'default'   => 0,
                                    'type'      => 'switch',
                            ),
                            array(
                                    'title'     => __( 'Width of Featured Images on Archives', 'shoestrap' ),
                                    'desc'      => __( 'Set dimensions of featured Images on Archives. Default: Full Width', 'shoestrap' ),
                                    'id'        => $key . '_feat_img_archive_custom_toggle',
                                    'default'   => 0,
                                    'required'  => array( $key . '_feat_img_archive','=',array( '1' ) ),
                                    'off'       => __( 'Full Width', 'shoestrap' ),
                                    'on'        => __( 'Custom Dimensions', 'shoestrap' ),
                                    'type'      => 'switch',
                            ),
                            array(
                                    'title'     => __( 'Archives Featured Image Custom Width', 'shoestrap' ),
                                    'desc'      => __( 'Select the width of your featured images on single posts. Default: 550px', 'shoestrap' ),
                                    'id'        => $key . '_feat_img_archive_width',
                                    'default'   => 550,
                                    'min'       => 100,
                                    'step'      => 1,
                                    'max'       => $screen_large_desktop,
                                    'required'  => array(
                                            array( $key . '_feat_img_archive', '=', 1 ),
                                            array( $key . '_feat_img_archive_custom_toggle', '=', 1 ),
                                    ),
                                    'edit'      => 1,
                                    'type'      => 'slider'
                            ),
                            array(
                                    'title'     => __( 'Archives Featured Image Custom Height', 'shoestrap' ),
                                    'desc'      => __( 'Select the height of your featured images on post archives. Default: 300px', 'shoestrap' ),
                                    'id'        => $key . '_feat_img_archive_height',
                                    'default'   => 300,
                                    'min'       => 50,
                                    'step'      => 1,
                                    'edit'      => 1,
                                    'max'       => $screen_large_desktop,
                                    'required'  => array( $key . '_feat_img_archive', '=', 1 ),
                                    'type'      => 'slider'
                            ),
                            array(
                                    'title'     => __( 'Featured Images on '.$post_type->labels->name, 'shoestrap' ),
                                    'desc'      => __( 'Display featured Images on posts. Default: OFF.', 'shoestrap' ),
                                    'id'        => $key . '_feat_img_post',
                                    'default'   => 0,
                                    'type'      => 'switch',
                            ),
                            array(
                                    'title'     => __( 'Width of Featured Images on '.$post_type->labels->name, 'shoestrap' ),
                                    'desc'      => __( 'Set dimensions of featured Images on Posts. Default: Full Width', 'shoestrap' ),
                                    'id'        => $key . '_feat_img_post_custom_toggle',
                                    'default'   => 0,
                                    'off'       => __( 'Full Width', 'shoestrap' ),
                                    'on'        => __( 'Custom Dimensions', 'shoestrap' ),
                                    'type'      => 'switch',
                                    'required'  => array( $key . '_feat_img_post', '=', 1 ),
                            ),
                            array(
                                    'title'     => __( $post_type->labels->name.' Featured Image Custom Width', 'shoestrap' ),
                                    'desc'      => __( 'Select the width of your featured images on single posts. Default: 550px', 'shoestrap' ),
                                    'id'        => $key . '_feat_img_post_width',
                                    'default'   => 550,
                                    'min'       => 100,
                                    'step'      => 1,
                                    'max'       => $screen_large_desktop,
                                    'edit'      => 1,
                                    'required'  => array(
                                            array( $key . '_feat_img_post', '=', 1 ),
                                            array( $key . '_feat_img_post_custom_toggle', '=', 1 ),
                                    ),
                                    'type'      => 'slider'
                            ),
                            array(
                                    'title'     => __( 'Posts Featured Image Custom Height', 'shoestrap' ),
                                    'desc'      => __( 'Select the height of your featured images on single posts. Default: 330px', 'shoestrap' ),
                                    'id'        => $key . '_feat_img_post_height',
                                    'default'   => 330,
                                    'min'       => 50,
                                    'step'      => 1,
                                    'max'       => $screen_large_desktop,
                                    'edit'      => 1,
                                    'required'  => array( $key . '_feat_img_post', '=', 1 ),
                                    'type'      => 'slider'
                            )
                        ));
                        
                        $section['fields'] = $fields;

                        $section = apply_filters( 'shoestrap_module_footer_options_modifier', $section );
                        
                        foreach($sections as $i=>$sec) {
                            if($sec['title']==$post_type->labels->name) break;
                        }
                        
                        array_splice($sections, $i+1, 0, array ( $section ));

                    endif;
                endforeach;

                return $sections;
            }
        }
        
        $cpt_options = new ShoestrapCptImagesSections();
    }
}